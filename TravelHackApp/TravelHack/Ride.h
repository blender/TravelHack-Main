//
//  Ride.h
//  TravelHack
//
//  Created by Tommaso Piazza on 10/8/11.
//  Copyright (c) 2011 ChalmersTH. All rights reserved.
//

#import <Foundation/Foundation.h>

@interface Ride : NSObject


+(Ride *) rideWithDictionary:(NSDictionary *) theDic;
-(Ride *) initWithDictionary:(NSDictionary *) theDic;

@property (strong, nonatomic) NSString *exptime;
@property (assign, nonatomic) double fromlang;
@property (assign, nonatomic) double fromlat;
@property (strong, nonatomic) NSString *fromtime;
@property (assign, nonatomic) unsigned int rideid;
@property (assign, nonatomic) unsigned int routeid;
@property (assign, nonatomic) double tolang;
@property (assign, nonatomic) double tolat;
@property (strong, nonatomic) NSString *totime;
@property (assign, nonatomic) BOOL confirmed;
@property (strong, nonatomic) NSString *rideName;
@property (assign, nonatomic) unsigned int passengerNo;
@property (strong, nonatomic) NSString *toName;
@property (strong, nonatomic) NSString *fromName;

@end
