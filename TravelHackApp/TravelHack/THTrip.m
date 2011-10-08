//
//  THLocation.m
//  TravelHack
//
//  Created by Tommaso Piazza on 10/8/11.
//  Copyright (c) 2011 ChalmersTH. All rights reserved.
//

#import "THTrip.h"

@implementation THTrip


@synthesize fromCoordinates = _fromCoordinates;
@synthesize toCoordinates = _toCoordinatesl;
@synthesize fromString = _fromString;
@synthesize toString = _toString;

+ (id)sharedInstance
{
    static dispatch_once_t pred = 0;
    __strong static id _sharedObject = nil;
    dispatch_once(&pred, ^{
        _sharedObject = [[self alloc] init];
    });
    return _sharedObject;
}



@end
