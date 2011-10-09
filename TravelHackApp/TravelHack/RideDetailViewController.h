//
//  RideDetailViewController.h
//  TravelHack
//
//  Created by Tommaso Piazza on 10/9/11.
//  Copyright (c) 2011 ChalmersTH. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "Ride.h"
#import "ASIHTTPRequest.h"


@interface RideDetailViewController : UIViewController <ASIHTTPRequestDelegate, UIAlertViewDelegate>


-(IBAction) joinRide:(id)sender;

@property (strong, nonatomic) IBOutlet UILabel *fromLabel;
@property (strong, nonatomic) IBOutlet UILabel *toLabel;
@property (strong, nonatomic) IBOutlet UILabel *priceLabel;
@property (strong, nonatomic) IBOutlet UILabel *passengerNoLabel;
@property (strong, nonatomic) IBOutlet UILabel *co2Label;
@property (strong, nonatomic) IBOutlet UIButton *joinButton;

@property (strong, nonatomic) Ride *ride;

@end
