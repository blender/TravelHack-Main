//
//  LocationController.h
//  TravelHack
//
//  Created by Tommaso Piazza on 10/8/11.
//  Copyright (c) 2011 ChalmersTH. All rights reserved.
//

#import <Foundation/Foundation.h>
#import <CoreLocation/CoreLocation.h>
#import <CoreLocation/CLLocationManagerDelegate.h>

@protocol LocationControllerDelegate <NSObject> 
@required
- (void)locationUpdate:(CLLocation *)location; // Our location updates are sent here
- (void)locationError:(NSError *)error; // Any errors are sent here
@end

@interface LocationController : NSObject <CLLocationManagerDelegate>
{

    CLLocationManager *locMgr;
    __weak id <LocationControllerDelegate> delegate;
}

+ (id)sharedInstance;

@property (nonatomic, strong) CLLocationManager *locMgr;
@property (nonatomic, weak) id <LocationControllerDelegate> delegate;

@end
