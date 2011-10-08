//
//  FirstViewController.h
//  TravelHack
//
//  Created by Tommaso Piazza on 10/3/11.
//  Copyright (c) 2011 ChalmersTH. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "SecondViewController.h"
#import "THTrip.h"
#import "ASIHTTPRequest.h"
#import "CJSONDeserializer.h"

@interface FirstViewController : UIViewController <ASIHTTPRequestDelegate>
{
    UIButton *_fromButton;
    UIButton *_toButton;
    UIButton *_swithButton;
    UITableView *_whenTableView;
    THTrip *trip;
}

@property (strong, nonatomic) IBOutlet UIButton *fromButton;
@property (strong, nonatomic) IBOutlet UIButton *toButton;
@property (strong, nonatomic) IBOutlet UIButton *switchButton;
@property (strong, nonatomic) IBOutlet UITableView *whenTableView;

-(IBAction) triggerMap:(id) sender;
-(IBAction) switchLocations:(id)sender;
-(IBAction) grabURLInBackground:(id)sender;

@end
