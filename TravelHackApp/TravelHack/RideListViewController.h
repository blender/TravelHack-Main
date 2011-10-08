//
//  RideListViewController.h
//  TravelHack
//
//  Created by Tommaso Piazza on 10/8/11.
//  Copyright (c) 2011 ChalmersTH. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "Ride.h"

@interface RideListViewController : UITableViewController <UITableViewDataSource, UITableViewDelegate>
{
    
    NSMutableArray *rideArray;
    
}

@property (strong, nonatomic) NSDictionary *rideDictionary;
@end
