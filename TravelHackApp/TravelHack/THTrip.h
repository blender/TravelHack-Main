//
//  THLocation.h
//  TravelHack
//
//  Created by Tommaso Piazza on 10/8/11.
//  Copyright (c) 2011 ChalmersTH. All rights reserved.
//

#import <Foundation/Foundation.h>
#import <MapKit/MapKit.h>

@interface THTrip : NSObject
{
    NSString *_fromString;
    NSString *_toString;
    CLLocationCoordinate2D _fromCoordinates;
    CLLocationCoordinate2D _toCoordinates;
    
}

@property (strong, nonatomic) NSString *fromString;
@property (strong, nonatomic) NSString *toString;
@property (assign, nonatomic) CLLocationCoordinate2D fromCoordinates;
@property (assign, nonatomic) CLLocationCoordinate2D toCoordinates;

+ (id)sharedInstance;

@end
