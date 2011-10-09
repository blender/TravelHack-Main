//
//  RideListViewController.m
//  TravelHack
//
//  Created by Tommaso Piazza on 10/8/11.
//  Copyright (c) 2011 ChalmersTH. All rights reserved.
//

#import "RideListViewController.h"

@implementation RideListViewController

@synthesize rideDictionary;
@synthesize rideArray = _rideArray;
@synthesize tableView, myTrip;

- (id)initWithStyle:(UITableViewStyle)style
{
    self = [super initWithStyle:style];
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

- (void)viewDidLoad
{
    [super viewDidLoad];
    
    myTrip =  [THTrip sharedInstance];

    self.rideArray = [NSMutableArray arrayWithCapacity:3];
    self.tableView.backgroundColor = [UIColor colorWithPatternImage:[UIImage imageNamed:@"bluePattern.png"]];
    // Uncomment the following line to preserve selection between presentations.
    // self.clearsSelectionOnViewWillAppear = NO
 
    // Uncomment the following line to display an Edit button in the navigation bar for this view controller.
    // self.navigationItem.rightBarButtonItem = self.editButtonItem;
}

- (void)viewDidUnload
{
    [super viewDidUnload];
    // Release any retained subviews of the main view.
    // e.g. self.myOutlet = nil;
    
    self.view.backgroundColor = [UIColor redColor];
    
}

- (void)viewWillAppear:(BOOL)animated
{
    [super viewWillAppear:animated];
}

- (void)viewDidAppear:(BOOL)animated
{
    [super viewDidAppear:animated];
    //[self.navigationController setToolbarHidden:YES];
}

- (void)viewWillDisappear:(BOOL)animated
{
    [super viewWillDisappear:animated];
}

- (void)viewDidDisappear:(BOOL)animated
{
    [super viewDidDisappear:animated];
}

- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation
{
    // Return YES for supported orientations
    return (interfaceOrientation == UIInterfaceOrientationPortrait);
}

#pragma mark - Table view data source

- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView
{
#warning Potentially incomplete method implementation.
    // Return the number of sections.
    return 2;
}

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
#warning Incomplete method implementation.
    // Return the number of rows in the section.
    
    if(section == 0){
    return [[rideDictionary allKeys] count];
    }
    
    else return 1;
}

- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    static NSString *CellIdentifier = @"Cell";
    
    UITableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:CellIdentifier];
    if (cell == nil) {
        cell = [[UITableViewCell alloc] initWithStyle:UITableViewCellStyleSubtitle reuseIdentifier:CellIdentifier];
    }
    
    if([indexPath section] == 0){
        [self.rideArray addObject:[Ride rideWithDictionary:[rideDictionary objectForKey:[NSString stringWithFormat:@"%d", [indexPath row]]]]];
        
        
        
        NSString *toName = [[self.rideArray objectAtIndex:[indexPath row]] toName];
        NSString *fromName = [[self.rideArray objectAtIndex:[indexPath row]] fromName];
        
        cell.textLabel.text = [NSString stringWithFormat:@"%@ - %@", fromName, toName];
        cell.detailTextLabel.text = [NSString stringWithFormat:@"There are %d passengers", [[self.rideArray objectAtIndex:[indexPath row]] passengerNo]];
        
        cell.imageView.image = [UIImage imageNamed:@"car.png"];
        cell.accessoryType = UITableViewCellAccessoryDetailDisclosureButton;
    }
    
    if([indexPath section] == 1){
    
        UIButton *btn = [UIButton buttonWithType:UIButtonTypeRoundedRect];
        btn.frame = CGRectMake(0.0f, 0.0f, 300.0f, 45.0f);
        btn.titleLabel.textAlignment = UITextAlignmentCenter;
        [btn setTitle:@"Create ride anyway" forState:UIControlStateNormal];
        [btn setTitle:@"Create ride anyway" forState:UIControlStateSelected];
        [btn addTarget:self action:@selector(createRide:) forControlEvents:UIControlEventTouchUpInside];
        [cell.contentView addSubview:btn];
        cell.accessoryType = UITableViewCellAccessoryNone;
    
    
    }
    
    return cell;
}

-(void) createRide:(id)sender {


    NSLog(@"Do stuff");
    [self grabURLInBackground:sender];

}

- (IBAction)grabURLInBackground:(id)sender
{
    
    NSString *requestString = [NSString stringWithFormat:@"http://aliavi.com/proc.php?form=newride&fromlang=%f&fromlat=%f&fdate=14&fhour=12&fmin=12&tolang=%f&tolat=%f&tdate=14&thour=12&tmin=12&fromname=%@&toname=%@&output=json", myTrip.fromCoordinates.longitude,  myTrip.fromCoordinates.latitude,  myTrip.toCoordinates.longitude,  myTrip.toCoordinates.latitude, myTrip.fromString, myTrip.toString];
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
    UIAlertView *alert = [[UIAlertView alloc] initWithTitle:@"Ride Created!" message:@"Thank you, we'll keep you posted." delegate:self cancelButtonTitle:@"OK" otherButtonTitles:nil];
    [alert show];
}

- (void)requestFailed:(ASIHTTPRequest *)request
{
    NSError *error = [request error];
    
    NSLog([error description]);
}


#pragma mark - Table view delegate

- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{
    // Navigation logic may go here. Create and push another view controller.
    /*
     <#DetailViewController#> *detailViewController = [[<#DetailViewController#> alloc] initWithNibName:@"<#Nib name#>" bundle:nil];
     // ...
     // Pass the selected object to the new view controller.
     [self.navigationController pushViewController:detailViewController animated:YES];
     */
}

-(void) tableView:(UITableView *)tableView accessoryButtonTappedForRowWithIndexPath:(NSIndexPath *)indexPath{
    
    RideDetailViewController *rideDetailViewController = [[RideDetailViewController alloc] initWithNibName:@"RideDetailViewController" bundle:nil];
    
    rideDetailViewController.ride = [_rideArray objectAtIndex:[indexPath row]];
    [self.navigationController pushViewController:rideDetailViewController animated:YES];
    [self.navigationController setToolbarHidden:YES];

}

#pragma mark - AlertView Delegates

- (void)alertView:(UIAlertView *)alertView clickedButtonAtIndex:(NSInteger)buttonIndex{

    if(buttonIndex == 0){
    
        [self.navigationController popViewControllerAnimated:YES];
    }

}

@end
