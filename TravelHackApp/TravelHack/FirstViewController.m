//
//  FirstViewController.m
//  TravelHack
//
//  Created by Tommaso Piazza on 10/3/11.
//  Copyright (c) 2011 ChalmersTH. All rights reserved.
//

#import "FirstViewController.h"

@implementation FirstViewController

@synthesize fromButton = _fromButton;
@synthesize toButton = _toButton;
@synthesize switchButton = _swithButton;
@synthesize whenTableView = _whenTableView;
//@synthesize mapViewController = _mapViewController;


- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {

    }
    return self;
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
    
    trip =  [THTrip sharedInstance];
    
    self.title = @"Find me a ride";
    self.navigationItem.backBarButtonItem =[[UIBarButtonItem alloc] initWithImage:[UIImage imageNamed:@"53-house.png"] style:UIBarButtonItemStyleBordered target:nil action:nil];
    self.whenTableView.backgroundColor = [UIColor clearColor];
}

-(void) viewWillAppear:(BOOL)animated{

    if(trip.fromString != nil){
    
        self.fromButton.titleLabel.text = trip.fromString;
    }
    if(trip.toString != nil){
        
        self.toButton.titleLabel.text = trip.toString;
    }


}

- (void)viewDidUnload
{
    [super viewDidUnload];
    // Release any retained subviews of the main view.
    // e.g. self.myOutlet = nil;
}

- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation
{
    // Return YES for supported orientations
    return (interfaceOrientation == UIInterfaceOrientationPortrait);
}

#pragma mark - IBActions

-(IBAction)triggerMap:(id)sender
{
    SecondViewController *mapViewController = [[SecondViewController alloc] initWithNibName:@"SecondViewController" bundle:nil];
    
    UIView *tmp =  (UIView *) sender;
    
    switch (tmp.tag) {
        case 1:
            mapViewController.title = @"Pick up location";
            mapViewController.senderTag = 1; 
            break;
        case 2:
            mapViewController.title = @"Destination";
            mapViewController.senderTag = 2; 
            break;
        default:
            break;
    }

    [self.navigationController pushViewController:mapViewController animated:YES];
}

-(IBAction)switchLocations:(id)sender
{

    NSLog(@"Button Pushed");
    
}

- (IBAction)grabURLInBackground:(id)sender
{
   
    NSString *urlString = [NSString stringWithFormat:@"http://aliavi.com/proc.php?form=searchride&fromlang=%f&fromlat=%f&fdate=14&fhour=12&fmin=12&&tolang=%f&tolat=%f&&tdate=14&thour=12&tmin=12&output=json", trip.fromCoordinates.longitude, trip.fromCoordinates.latitude, trip.toCoordinates.longitude, trip.toCoordinates.latitude];
    
    //NSLog(urlString);
    
    NSURL *url = [NSURL URLWithString:urlString];
    ASIHTTPRequest *request = [ASIHTTPRequest requestWithURL:url];
    [request setDelegate:self];
    [request startAsynchronous];
}

- (void)requestFinished:(ASIHTTPRequest *)request
{
    // Use when fetching text data
    NSString *responseString = [request responseString];
    
    NSString *jsonString = responseString;
    NSData *jsonData = [jsonString dataUsingEncoding:NSUTF8StringEncoding];
    NSError *error = nil;
    NSDictionary *dictionary = [[CJSONDeserializer deserializer] deserializeAsDictionary:jsonData error:&error];
    
    if(error != nil){
    
        NSLog([error description]);
    
    }
    
    
    NSLog([dictionary description]);
    
}

- (void)requestFailed:(ASIHTTPRequest *)request
{
    NSError *error = [request error];
    NSLog([error description]);
}


@end
