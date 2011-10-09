//
//  SecondViewController.m
//  TravelHack
//
//  Created by Tommaso Piazza on 10/3/11.
//  Copyright (c) 2011 ChalmersTH. All rights reserved.
//

#import "SecondViewController.h"

@implementation SecondViewController
@synthesize mapView;
@synthesize senderTag = _senderTag;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewWillAppear:(BOOL)animated { 
    
    UILongPressGestureRecognizer *longPressGesture = [[UILongPressGestureRecognizer alloc] initWithTarget:self action:@selector(handleLongPressGesture:)];
    [self.mapView addGestureRecognizer:longPressGesture];

}

- (void)didReceiveMemoryWarning
{
    // Releases the view if it doesn't have a superview.
    [super didReceiveMemoryWarning];
    
    // Release any cached data, images, etc that aren't in use.
}

#pragma mark - View lifecycle

- (void)viewDidLoad
{
    [super viewDidLoad];
    
    // Do any additional setup after loading the view from its nib.
    
    trip = [THTrip sharedInstance];
    isInitialLocationSet = NO;
    mapView.delegate = self;
    
    UIBarButtonItem *rightButton = [[UIBarButtonItem alloc] initWithImage:[UIImage imageNamed:@"74-location.png"] style:UIBarButtonItemStyleDone target:self action:@selector(centerOnUserLocation)];
    self.navigationItem.rightBarButtonItem = rightButton;
    
}

- (void)viewDidUnload
{
    [self setMapView:nil];
    [super viewDidUnload];
    
    isInitialLocationSet = NO;
    // Release any retained subviews of the main view.
    // e.g. self.myOutlet = nil;
}

- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation
{
    // Return YES for supported orientations
    return (interfaceOrientation == UIInterfaceOrientationPortrait);
}

#pragma mark - MapViewDelegate Protocol

- (void)mapView:(MKMapView *)aMapView didUpdateUserLocation:(MKUserLocation *)aUserLocation {
    
    
    if(!isInitialLocationSet){
        
        isInitialLocationSet = YES;
    
        [self centerOnLocation:aUserLocation];
    
    }
}

- (MKAnnotationView *)mapView:(MKMapView *)mapView viewForAnnotation:(id <MKAnnotation>)annotation {
    
    static NSString *identifier = @"AddressAnnotation";   
    if ([annotation isKindOfClass:[AddressAnnotation class]]) {
        
        MKPinAnnotationView *annotationView = (MKPinAnnotationView *) [self.mapView dequeueReusableAnnotationViewWithIdentifier:identifier];
        if (annotationView == nil) {
            annotationView = [[MKPinAnnotationView alloc] initWithAnnotation:annotation reuseIdentifier:identifier];
        } else {
            annotationView.annotation = annotation;
        }
        
        annotationView.enabled = YES;
        annotationView.canShowCallout = YES;
        annotationView.pinColor = MKPinAnnotationColorGreen;
        annotationView.animatesDrop=TRUE;
        annotationView.canShowCallout = YES;
        annotationView.calloutOffset = CGPointMake(-5, 5);
        
        UIButton* rightButton = [UIButton buttonWithType:UIButtonTypeDetailDisclosure];
        [rightButton addTarget:self action:@selector(confirmLocation:) forControlEvents:UIControlEventTouchUpInside];
        annotationView.rightCalloutAccessoryView = rightButton;
        
        return  annotationView;
    }
    
    return nil;

}

#pragma mark - Instance Methods

-(void) centerOnLocation:(MKUserLocation *)aUserLocation {

    MKCoordinateRegion region;
    MKCoordinateSpan span;
    span.latitudeDelta = 0.005;
    span.longitudeDelta = 0.005;
    CLLocationCoordinate2D location;
    location.latitude = aUserLocation.coordinate.latitude;
    location.longitude = aUserLocation.coordinate.longitude;
    region.span = span;
    region.center = location;
    [mapView setRegion:region animated:YES];

}

-(void) centerOnUserLocation{

    [self centerOnLocation:mapView.userLocation];
        
}


-(void) confirmLocation:(id)sender{


    switch (self.senderTag) {
        case 1:
            trip.fromString = [NSString stringWithFormat:@"%@ %@", dropPin.title, dropPin.subtitle];
            trip.fromCoordinates = locCoord;
            break;
        case 2:
            trip.toString = [NSString stringWithFormat:@"%@ %@", dropPin.title, dropPin.subtitle];
            trip.toCoordinates = locCoord;
            break;
        default:
            break;
    }
    
    [self.navigationController popViewControllerAnimated:YES];
}

#pragma mark - UIGestureRecognizer

-(void)handleLongPressGesture:(UIGestureRecognizer*)sender {
    // This is important if you only want to receive one tap and hold event
    if (sender.state == UIGestureRecognizerStateEnded)
    {
        //[self.mapView removeGestureRecognizer:sender];
    }
    else
    {
        if(dropPin != nil) {
            [mapView removeAnnotation:dropPin];
            dropPin = nil;
        }
        
        // Here we get the CGPoint for the touch and convert it to latitude and longitude coordinates to display on the map
        CGPoint point = [sender locationInView:self.mapView];
        locCoord = [self.mapView convertPoint:point toCoordinateFromView:self.mapView];
        dropPin = [[AddressAnnotation alloc] initWithCoordinate:locCoord];
        
        MKReverseGeocoder *geocoder = [[MKReverseGeocoder alloc] initWithCoordinate:locCoord];
        [geocoder setDelegate:self];
        [geocoder start];
    }
}


#pragma mark - Reverse Geocoder

- (void)reverseGeocoder:(MKReverseGeocoder *)geocoder didFindPlacemark:(MKPlacemark *)placemark
{
	//NSLog(@"The geocoder has returned: %@", [placemark addressDictionary]);
    
    dropPin.title = [[placemark addressDictionary] objectForKey:@"Thoroughfare"];
    dropPin.subtitle = [[placemark addressDictionary] objectForKey:@"SubThoroughfare"];
    [self.mapView addAnnotation:dropPin];
}

- (void)reverseGeocoder:(MKReverseGeocoder *)geocoder didFailWithError:(NSError *)error
{
    NSLog(@"reverseGeocoder:%@ didFailWithError:%@", geocoder, error);
}


@end
