//
//  LocationController.m
//  TravelHack
//
//  Created by Tommaso Piazza on 10/8/11.
//  Copyright (c) 2011 ChalmersTH. All rights reserved.
//

#import "LocationController.h"

@implementation LocationController

@synthesize locMgr, delegate;


+ (id)sharedInstance
{
    static dispatch_once_t pred = 0;
    __strong static id _sharedObject = nil;
    dispatch_once(&pred, ^{
        _sharedObject = [[self alloc] init];
    });
    return _sharedObject;
}

- (id)init {
	self = [super init];
    
	if(self != nil) {
		self.locMgr = [[CLLocationManager alloc] init]; // Create new instance of locMgr
		self.locMgr.delegate = self; // Set the delegate as self.
	}
    
	return self;
}

- (void)locationManager:(CLLocationManager *)manager didUpdateToLocation:(CLLocation *)newLocation fromLocation:(CLLocation *)oldLocation {
	
    if([self.delegate conformsToProtocol:@protocol(LocationControllerDelegate)]) {
		
        [self.delegate locationUpdate:newLocation];
	}
    
}

- (void)locationManager:(CLLocationManager *)manager didFailWithError:(NSError *)error {
	
    if([self.delegate conformsToProtocol:@protocol(LocationControllerDelegate)]) {  		
        
        [self.delegate locationError:error];
	}
}

@end
