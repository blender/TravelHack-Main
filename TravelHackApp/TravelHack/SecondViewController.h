//
//  SecondViewController.h
//  TravelHack
//
//  Created by Tommaso Piazza on 10/3/11.
//  Copyright (c) 2011 ChalmersTH. All rights reserved.
//

#import <UIKit/UIKit.h>
#import <MapKit/MapKit.h>
#import "LocationController.h"
#import "AddressAnnotation.h"
#import "THTrip.h"

@interface SecondViewController : UIViewController <MKMapViewDelegate, MKReverseGeocoderDelegate>
{
    BOOL isInitialLocationSet;
    AddressAnnotation *dropPin;
    THTrip *trip;
    NSInteger _senderTag;
    CLLocationCoordinate2D locCoord;
}

-(void) centerOnLocation:(MKUserLocation *) aUserLocation;
-(void) centerOnUserLocation;
-(void) handleLongPressGesture:(UIGestureRecognizer*)sender;
-(void) confirmLocation:(id)sender;

@property (strong, nonatomic) IBOutlet MKMapView *mapView;
@property (assign, nonatomic) NSInteger senderTag;

@end
