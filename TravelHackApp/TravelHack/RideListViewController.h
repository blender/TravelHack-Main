//
//  RideListViewController.h
//  TravelHack
//
//  Created by Tommaso Piazza on 10/8/11.
//  Copyright (c) 2011 ChalmersTH. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "Ride.h"
#import "RideDetailViewController.h"
#import "ASIHTTPRequest.h"
#import "THTrip.h"

@interface RideListViewController : UITableViewController <UITableViewDataSource, UITableViewDelegate, ASIHTTPRequestDelegate>
{
    
    NSMutableArray *_rideArray;
    
}

- (IBAction)grabURLInBackground:(id)sender;

@property (strong, nonatomic) NSDictionary *rideDictionary;
@property (strong, nonatomic) NSMutableArray *rideArray;
@property (strong, nonatomic) IBOutlet UITableView *tableView;
@property (strong, nonatomic) THTrip *myTrip;
-(void) createRide:(id) sender;
@end
