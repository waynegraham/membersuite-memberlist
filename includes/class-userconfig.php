<?php
class Userconfig {

	public static function read( $name ) {
		$membersuite_memberlist_options = get_option( 'membersuite_memberlist_option_name' );

		$config = array(
			'AccessKeyId'           => $membersuite_memberlist_options['accesskeyid_0'],
			'AssociationId'         => $membersuite_memberlist_options['associationid_1'],
			'SecretAccessKey'       => $membersuite_memberlist_options['secretaccesskey_2'],
			'SigningcertificateId'  => $membersuite_memberlist_options['signingcertificateid_3'],
			'SigningcertificateXml' => $membersuite_memberlist_options['singingcertificatexml_4'],
		  // 'PortalUrl' => $membersuite_memberlist_options['portalurl_5'],
		  // 'WPUsers' => $membersuite_memberlist_options['wpusers_6']
		);

		return $config[ $name ];
	}
}
