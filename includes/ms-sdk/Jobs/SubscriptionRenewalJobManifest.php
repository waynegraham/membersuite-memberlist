<?php
/*
 Subscription fot Renewal Job Manifest
*/

class SubscriptionRenewalJobManifest {

	// <summary>
	// Gets or sets the publication ID.
	// </summary>
	// <value>The publication ID.</value>
	// <remarks></remarks>
	public $PublicationID;
	// <summary>
	// Gets or sets the name of the batch.
	// </summary>
	// <value>The name of the batch.</value>
	// <remarks></remarks>
	public $BatchName;

	// <summary>
	// Gets or sets a value indicating whether [send out emails].
	// </summary>
	// <value><c>true</c> if [send out emails]; otherwise, <c>false</c>.</value>
	// <remarks></remarks>
	public $SendOutEmails;

	// <summary>
		// Gets or sets the subscription search to use for renewal.
		// </summary>
		// <value>The subscription search to use for renewal.</value>
		// <remarks></remarks>
	public $SubscriptionSearchToUseForRenewal; // Search Object
}
