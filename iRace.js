$(document).ready(function() {
	//start();
	tool();
});

function start() {
	var uname = prompt("Please enter your username:", "");
	var pword = prompt("Please enter your password:", "");
	if (uname == "irace" && pword == "jahrakal") {
		tool();
	} else {
		alert("Username or password is invalid");
		document.location = "http://irace.ph/tools/iRace.html";
	}
}

function tool() {
	$('#RacesContainer').jtable({
		title : 'Table of Races',
		paging : true,
		pageSize : 100,
		sorting : true,
		defaultSorting : 'race_id ASC',
		openChildAsAccordion : true, //Enable this line to show child tabes as accordion style
		actions : {
			listAction : 'scripts/RaceAction.php?action=list',
			createAction : 'scripts/RaceAction.php?action=create',
			updateAction : 'scripts/RaceAction.php?action=update',
			deleteAction : 'scripts/RaceAction.php?action=delete'
		},
		fields : {
			Distances : {
				title : '',
				width : '5%',
				sorting : true,
				edit : true,
				create : true,
				display : function(data) {
					//Create an image that will be used to open child table
					var $img = $('<img src="css/themes/metro/list_metro.png" title="Distances" />');
					//Open child table when user clicks the image
					$img.click(function() {
						$('#RacesContainer').jtable('openChildTable', $img.closest('tr'), //Parent row
						{
							title : data.record.race_title + ' - Distances',
							paging : true,
							pageSize : 100,
							sorting : true,
							defaultSorting : 'dist_id ASC',
							actions : {
								listAction : 'scripts/DistanceAction.php?action=list&race_id=' + data.record.race_id,
								deleteAction : 'scripts/DistanceAction.php?action=delete',
								updateAction : 'scripts/DistanceAction.php?action=update',
								createAction : 'scripts/DistanceAction.php?action=create'
							},
							fields : {
								Registrants : {
									title : '',
									sorting : true,
									edit : true,
									create : true,
									display : function(data) {
										//Create an image that will be used to open child table
										var $img = $('<img src="css/themes/metro/list_metro.png" title="Distances" />');
										//Open child table when user clicks the image
										$img.click(function() {
											$('#RacesContainer').jtable('openChildTable', $img.closest('tr'), //Parent row
											{
												title : data.record.dist_name + ' - Registrants',
												paging : true,
												pageSize : 100,
												sorting : true,
												defaultSorting : 'reg_id ASC',
												actions : {
													listAction : 'scripts/RegistrationAction.php?action=list&dist_id=' + data.record.dist_id,
													deleteAction : 'scripts/RegistrationAction.php?action=delete',
													updateAction : 'scripts/RegistrationAction.php?action=update',
													createAction : 'scripts/RegistrationAction.php?action=create'
												},
												fields : {
													Emergency : {
														title : '',
														width : '5%',
														sorting : false,
														edit : false,
														create : false,
														display : function(data) {
															//Create an image that will be used to open child table
															var $img = $('<img src="css/themes/metro/list_metro.png" title="Emergency Contact Details" />');
															//Open child table when user clicks the image
															$img.click(function() {
																$('#RacesContainer').jtable('openChildTable', $img.closest('tr'), //Parent row
																{
																	title : data.record.reg_name + ' - Emergency Contact Details',
																	actions : {
																		listAction : 'scripts/EmergencyList.php?action=list&reg_id=' + data.record.reg_id,
																		updateAction : 'scripts/RegistrationAction.php?action=update&reg_id=' + data.record.reg_id,
																	},
																	fields : {
																		reg_id : {
																			title : 'ID',
																			key : true,
																			list : false
																		},
																		reg_e_name : {
																			title : 'Name',
																			width : '20%'
																		},
																		reg_e_relationship : {
																			title : 'Relationship',
																			width : '20%'
																		},
																		reg_e_contact : {
																			title : 'Contact',
																			width : '20%'
																		}
																	}
																}, function(data) {//opened handler
																	data.childTable.jtable('load');
																});
															});
															//Return image to show on the person row
															return $img;
														}
													},
													dist_id : {
														type : 'hidden',
														defaultValue : data.record.dist_id,
														hidden : true
													},
													user_id : {
														title : 'User ID',
														//key: true,
														list : false
													},
													reg_bib : {
														title : 'Bib #',
														width : '5%'
													},
													reg_id : {
														title : 'ID',
														key : true,
														list : false,
														hidden : true
													},
													reg_date : {
														title : 'Registration Date',
														width : '5%',
														type : 'date'
													},
													reg_name : {
														title : 'Name',
														width : '10%'
													},
													reg_gender : {
														title : 'Gender',
														type : 'radiobutton',
														options : {
															'M' : 'Male',
															'F' : 'Female',
														}
													},
													reg_address : {
														title : 'Address',
														width : '10%'
													},
													reg_email : {
														title : 'Email',
														width : '2%'
													},
													reg_mobile : {
														title : 'Mobile',
														width : '10%'
													},
													reg_birthday : {
														title : 'Birthday',
														width : '5%',
														type : 'date'
													},
													reg_affiliation : {
														title : 'Affiliation',
														width : '7%'
													},
													reg_shirt_size : {
														title : 'Shirt Size',
														width : '2%'
													},
													reg_status : {
														title : 'Status',
														type : 'checkbox',
														values : {
															'0' : 'Unpaid',
															'1' : 'Paid'
														},
														defaultValue : 'Unpaid'
													},
													reg_del_address : {
														title : 'Delivery Address',
														width : '20%'
													},
													reg_note : {
														title : 'Notes',
														width : '15%'
													}
												}
											}, function(data) {//opened handler
												data.childTable.jtable('load');
											});
										});
										//Return image to show on the person row
										return $img;
									}
								},

								race_id : {
									type : 'hidden',
									defaultValue : data.record.race_id
								},
								dist_id : {
									title : 'ID',
									key : true,
									width : '5%'
								},
								dist_name : {
									title : 'Distances',
									width : '45%'
								},
								dist_type : {
									title : 'Type',
									width : '20%',
									type : 'radiobutton',
									options : {
										'1' : 'Run',
										'2' : 'Dua',
										'3' : 'Tri',
										'4' : 'Aqua'
									}
								},
								dist_price : {
									title : 'Price',
									width : '30%'
								}
							}
						}, function(data) {//opened handler
							data.childTable.jtable('load');
						});
					});
					//Return image to show on the person row
					return $img;
				}
			},
			race_id : {
				title : 'ID',
				width : '5%',
				key : true,
			},
			race_title : {
				title : 'Race Title',
				width : '30%'
			},
			race_date : {
				title : 'Race Date',
				width : '10%',
				type : 'date'
			},
			race_location : {
				title : 'Race Location',
				width : '25%'
			}
		}
	});
	//Load student list from server
	$('#RacesContainer').jtable('load');
}
