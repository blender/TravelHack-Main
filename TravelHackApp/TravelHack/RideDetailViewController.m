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


#pragma mark - Instance Methods


-(IBAction)joinRide:(id)sender{
    
    NSString *requestString = [NSString stringWithFormat:@"http://aliavi.com/proc.php?form=joinride&rideid=%d", ride.rideid];
    NSLog(@"URL STRING: %@", [requestString stringByAddingPercentEscapesUsingEncoding:NSUTF8StringEncoding]);
    NSURL *requestUrl = [NSURL URLWithString:[requestString stringByAddingPercentEscapesUsingEncoding:NSUTF8StringEncoding]];
    ASIHTTPRequest *request = [ASIHTTPRequest requestWithURL:requestUrl];
    [request setDelegate:self];
    [request startAsynchronous];
}

#pragma mark - ASIHTTPRequest Delegates

- (void)requestFinished:(ASIHTTPRequest *)request
{
    // Use when fetching text data
    UIAlertView *alert = [[UIAlertView alloc] initWithTitle:@"You joined this ride!" message:@"Thank you, we'll keep you posted." delegate:self cancelButtonTitle:@"OK" otherButtonTitles:nil];
    [alert show];
}

- (void)requestFailed:(ASIHTTPRequest *)request
{
    NSError *error = [request error];
    
    NSLog([error description]);
}

#pragma mark - AlertView Delegates

- (void)alertView:(UIAlertView *)alertView clickedButtonAtIndex:(NSInteger)buttonIndex{
    
    if(buttonIndex == 0){
        
        [self.navigationController popToRootViewControllerAnimated:YES];
    }
    
}


@end
