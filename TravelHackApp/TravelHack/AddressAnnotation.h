//
//  AddressAnnotation.h
//  TravelHack
//
//  Created by Tommaso Piazza on 10/8/11.
//  Copyright (c) 2011 ChalmersTH. All rights reserved.
//

#import <Foundation/Foundation.h>
#import <MapKit/MapKit.h>

@interface AddressAnnotation : NSObject <MKAnnotation> {
    
    CLLocationCoordinate2D coordinate;
    NSString *_title;
    NSString *_subtitle;
}

@property (strong, nonatomic) NSString *title;
@property (strong, nonatomic) NSString *subtitle;

-(id)initWithCoordinate:(CLLocationCoordinate2D) c;


@end
