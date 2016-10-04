<?php

$Module = $Params['Module'];

$res = eZTemplateDesignResource::instance();
$res->setKeys( array( array( 'layout', 'ajax' ) ) );

if ( eZINI::instance()->variable( 'SiteAccessSettings', 'RequireUserLogin' ) == true && !eZUser::currentUser()->isLoggedIn() )
{
    header( $_SERVER['SERVER_PROTOCOL'] . ' 403 User not logged in' );
    return $Module->handleError( eZError::KERNEL_ACCESS_DENIED, 'kernel' );
}

$userParamString = '';
foreach ( $Params['UserParameters'] as $key => $param )
{
    $userParamString .= "/($key)/$param";
}

$GLOBALS['REQUESTED_VIA_AJAX'] = true;

$Result = array();
$Result['content'] = '';
$Result['rerun_uri'] = '/' . implode( $Params['Parameters'], '/' ) . $userParamString;
$Result['pagelayout'] = 'pagelayout_ajax.tpl';
$Module->setExitStatus( eZModule::STATUS_RERUN );
