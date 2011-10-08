//
//  WhenViewController.h
//  TravelHack
//
//  Created by Tommaso Piazza on 10/7/11.
//  Copyright (c) 2011 ChalmersTH. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface WhenViewController : UITableViewController <UITableViewDelegate, UITableViewDataSource>
{
    
    UILabel *_leftLabelForCell;
    
}

@property (strong, nonatomic) UILabel *leftLabelForCell;

@end
