//
//  RideDetailViewController.m
//  TravelHack
//
//  Created by Tommaso Piazza on 10/9/11.
//  Copyright (c) 2011 ChalmersTH. All rights reserved.
//

#import "RideDetailViewController.h"

@implementation RideDetailViewController
@synthesize ride, fromLabel, toLabel, priceLabel, passengerNoLabel, co2Label, joinButton;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)didReceiveMemoryWarning
{
    // Releases the view if it doesn't have a superview.
    [super didReceiveMemoryWarning];
    
    // Release any cached data, images, etc that aren't in use.
}

#pragma mark - View lifecycle

- (void) viewWillDisappear:(BOOL)animated{

    [self.navigationController setToolbarHidden:YES];
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    self.view.backgroundColor = [UIColor colorWithPatternImage:[UIImage imageNamed:@"bluePattern.png"]];
    self.fromLabel.text = ride.fromName;
    self.toLabel.text = ride.toName;
    self.passengerNoLabel.text = [NSString stringWithFormat:@"%d", ride.passengerNo];
    self.co2Label.text = [NSString stringWithFormat:@"%.2fg", 2.5];
    self.priceLabel.text = @"3";
    // Do any additional setup after loading the view from its nib.
}

- (void)viewDidUnload
{
    [super viewDidUnload];
    // Release any retained subviews of the main view.
    // e.g. self.myOutlet = nil;
}

- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation
{
    // Return YES for supported orientations
    return (interfaceOrientation == UIInterfaceOrientationPortrait);
}

@end
