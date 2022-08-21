<?php

// The version number (9_5_0) should match version of the Chilkat extension used, omitting the micro-version number.
// For example, if using Chilkat v9.5.0.48, then include as shown here:

ini_set('memory_limit', '100M');

include("chilkat_9_5_0.php");

// This example requires the Chilkat API to have been previously unlocked.
// See Global Unlock Sample for sample code.

// To begin, we'll need a PFX containing a certificate and private key, and the SOAP XML to be signed.
// Chilkat provides sample data at chilkatsoft.com and chilkatdownload.com, and our first step is to download.

// -------------------------------------------------------------------------
// Step 1: Get the SOAP XML template to be signed.
// 
$sbXml = new_CkStringBuilder();

$http = new CkHttp();
$success = $http->QuickGetSb('soap.xml',$sbXml);
if ($success != true) {
    print $http->lastErrorText() . "\n";
    exit;
}

// The SOAP XML template contains this:

// <?xml version="1.0" encoding="UTF8"?>
// <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/">
// <SOAP-ENV:Header>
//  <wsse:Security xmlns:ds="http://www.w3.org/2000/09/xmldsig#"
//                 xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
//                 xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd"
//                 xmlns:xenc="http://www.w3.org/2001/04/xmlenc#" SOAP-ENV:mustUnderstand="1">
//  <wsse:BinarySecurityToken
//                EncodingType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-soap-message-security-1.0#Base64Binary"
//                ValueType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-x509-token-profile-1.0#X509"
//                wsu:Id="x509cert00">BASE64_CERT</wsse:BinarySecurityToken>
//  </wsse:Security>
// </SOAP-ENV:Header>
// <SOAP-ENV:Body xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd" wsu:Id="TheBody">
//  <getVersion xmlns="http://msgsec.wssecfvt.ws.ibm.com"/>
// </SOAP-ENV:Body>
// </SOAP-ENV:Envelope>
// 

// -------------------------------------------------------------------------
// Step 2: Get the test certificate and private key stored in a .pfx
// 
$pfxData = new CkBinData();
$success = $http->QuickGetBd('901162935 GRUPO INEDITTO.pfx',$pfxData);
if ($success != true) {
    print $http->lastErrorText() . "\n";
    exit;
}

$pfx = new CkPfx();
$password = '901162935';
$success = $pfx->LoadPfxEncoded($pfxData->getEncoded('base64'),'base64',$password);
if ($success != true) {
    print $pfx->lastErrorText() . "\n";
    exit;
}

// -------------------------------------------------------------------------
// Step 3: Get the certificate from the PFX.
// 
// cert is a CkCert
$cert = $pfx->GetCert(0);
if ($pfx->get_LastMethodSuccess() != true) {
    print $pfx->lastErrorText() . "\n";
    exit;
}

// -------------------------------------------------------------------------
// Step 4: Replace "BASE64_CERT" with the actual base64 encoded certificate.
// 
$bdCert = new CkBinData();
$cert->ExportCertDerBd($bdCert);

$numReplaced = $sbXml->Replace('BASE64_CERT',$bdCert->getEncoded('base64'));

// -------------------------------------------------------------------------
// Step 5: Build the wsse:SecurityTokenReference XML.
// This will be the CustomKeyInfoXml (see below).
// 
$refXml = new CkXml();
$refXml->put_Tag('wsse:SecurityTokenReference');
$refXml->UpdateAttrAt('wsse:Reference',true,'URI','#x509cert00');
$refXml->UpdateAttrAt('wsse:Reference',true,'ValueType','http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-x509-token-profile-1.0#X509');

// The above lines of code builds the following XML:

// 	<wsse:SecurityTokenReference>
// 	    <wsse:Reference URI="#x509cert00" ValueType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-x509-token-profile-1.0#X509" />
// 	</wsse:SecurityTokenReference>
// 
$refXml->put_EmitXmlDecl(false);
print $refXml->getXml() . "\n";

// -------------------------------------------------------------------------
// Step 6: Setup the XML Digital Signature Generator and add the XML Signature.
// 
$gen = new CkXmlDSigGen();
$gen->put_SigLocation('SOAP-ENV:Envelope|SOAP-ENV:Header|wsse:Security');
$gen->put_SignedInfoPrefixList('wsse SOAP-ENV');
$gen->AddSameDocRef('TheBody','sha1','EXCL_C14N','','');
$gen->put_KeyInfoType('Custom');
$refXml->put_EmitCompact(true);

$gen->put_CustomKeyInfoXml($refXml->getXml());
$gen->SetX509Cert($cert,true);

$success = $gen->CreateXmlDSigSb($sbXml);
if ($success != true) {
    print $gen->lastErrorText() . "\n";
    exit;
}

// Examine the signed XML
print $sbXml->getAsString() . "\n";

// Pretty-printed, the XML signature looks as shown here: 
// (The exact XML signature is shown below. Pretty-printing invalidates the XML signature.)

// <?xml version="1.0" encoding="UTF8" ?>
// <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/">
//     <SOAP-ENV:Header>
//         <wsse:Security xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd" xmlns:xenc="http://www.w3.org/2001/04/xmlenc#" SOAP-ENV:mustUnderstand="1">
//             <wsse:BinarySecurityToken EncodingType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-soap-message-security-1.0#Base64Binary" ValueType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-x509-token-profile-1.0#X509" wsu:Id="x509cert00">MIID...</wsse:BinarySecurityToken>
//             <ds:Signature xmlns:ds="http://www.w3.org/2000/09/xmldsig#">
//                 <ds:SignedInfo>
//                     <ds:CanonicalizationMethod Algorithm="http://www.w3.org/2001/10/xml-exc-c14n#">
//                         <InclusiveNamespaces xmlns="http://www.w3.org/2001/10/xml-exc-c14n#" PrefixList="wsse SOAP-ENV" />
//                     </ds:CanonicalizationMethod>
//                     <ds:SignatureMethod Algorithm="http://www.w3.org/2001/04/xmldsig-more#rsa-sha256" />
//                     <ds:Reference URI="#TheBody">
//                         <ds:Transforms>
//                             <ds:Transform Algorithm="http://www.w3.org/2001/10/xml-exc-c14n#" />
//                         </ds:Transforms>
//                         <ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1" />
//                         <ds:DigestValue>VhsSnaEAFsY0OYegKQh99v9csXg=</ds:DigestValue>
//                     </ds:Reference>
//                 </ds:SignedInfo>
//                 <ds:SignatureValue>Ynp3H4rtzpXIh4TaVxkpEkS1bMCCu672aeCzUOzheNNfnpmLsCZz3+zQjMBbchPggCayC5ihpEdhRe3XvPXjPXXAgxDP4mic091QPmjHlmUcu8yqRKfxnPtD35nqaxDtCYw+jGIzj+ch094vA4RPCfY8JQnb1mpy1ZjjsMW8741CIh1epbsd/0bZt6tfINUQ37seg07yvLbCJZ/Zf+h8FlFryQk6lHTTeZl/GfQ9NlDBcShby3x8Hc1KwW++zFqEA7G783R9AYPYn3fWTOBhYk5gkgFc+HaPRLR/L0Bp7ZPbmOR/iZQ+HK4W672tTdN/R2GdN7/deV7QTp2DYK1Z8w==</ds:SignatureValue>
//                 <ds:KeyInfo>
//                     <wsse:SecurityTokenReference>
//                         <wsse:Reference URI="#x509cert00" ValueType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-x509-token-profile-1.0#X509" />
//                     </wsse:SecurityTokenReference>
//                 </ds:KeyInfo>
//             </ds:Signature>
//         </wsse:Security>
//     </SOAP-ENV:Header>
//     <SOAP-ENV:Body xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd" wsu:Id="TheBody">
//         <getVersion xmlns="http://msgsec.wssecfvt.ws.ibm.com" />
//     </SOAP-ENV:Body>
// </SOAP-ENV:Envelope>
// 

// --------------------------------------------------------------------------------------------
// This is the XML signature, which is also available at https://www.chilkatsoft.com/exampleData/signedSoapBinarySecurityToken.xml
// 

// <?xml version="1.0" encoding="UTF8"?>
// <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/">
// <SOAP-ENV:Header>
//  <wsse:Security xmlns:ds="http://www.w3.org/2000/09/xmldsig#"
//                 xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
//                 xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd"
//                 xmlns:xenc="http://www.w3.org/2001/04/xmlenc#" SOAP-ENV:mustUnderstand="1">
//  <wsse:BinarySecurityToken
//                EncodingType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-soap-message-security-1.0#Base64Binary"
//                ValueType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-x509-token-profile-1.0#X509"
//                wsu:Id="x509cert00">MIIDg...</wsse:BinarySecurityToken>
//  <ds:Signature xmlns:ds="http://www.w3.org/2000/09/xmldsig#"><ds:SignedInfo><ds:CanonicalizationMethod Algorithm="http://www.w3.org/2001/10/xml-exc-c14n#"><InclusiveNamespaces xmlns="http://www.w3.org/2001/10/xml-exc-c14n#" PrefixList="wsse SOAP-ENV"/></ds:CanonicalizationMethod><ds:SignatureMethod Algorithm="http://www.w3.org/2001/04/xmldsig-more#rsa-sha256"/><ds:Reference URI="#TheBody"><ds:Transforms><ds:Transform Algorithm="http://www.w3.org/2001/10/xml-exc-c14n#"/></ds:Transforms><ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1"/><ds:DigestValue>VhsSnaEAFsY0OYegKQh99v9csXg=</ds:DigestValue></ds:Reference></ds:SignedInfo><ds:SignatureValue>Ynp3H4rtzpXIh4TaVxkpEkS1bMCCu672aeCzUOzheNNfnpmLsCZz3+zQjMBbchPggCayC5ihpEdhRe3XvPXjPXXAgxDP4mic091QPmjHlmUcu8yqRKfxnPtD35nqaxDtCYw+jGIzj+ch094vA4RPCfY8JQnb1mpy1ZjjsMW8741CIh1epbsd/0bZt6tfINUQ37seg07yvLbCJZ/Zf+h8FlFryQk6lHTTeZl/GfQ9NlDBcShby3x8Hc1KwW++zFqEA7G783R9AYPYn3fWTOBhYk5gkgFc+HaPRLR/L0Bp7ZPbmOR/iZQ+HK4W672tTdN/R2GdN7/deV7QTp2DYK1Z8w==</ds:SignatureValue><ds:KeyInfo><wsse:SecurityTokenReference><wsse:Reference URI="#x509cert00" ValueType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-x509-token-profile-1.0#X509" /></wsse:SecurityTokenReference></ds:KeyInfo></ds:Signature></wsse:Security>
// </SOAP-ENV:Header>
// <SOAP-ENV:Body xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd" wsu:Id="TheBody">
//  <getVersion xmlns="http://msgsec.wssecfvt.ws.ibm.com"/>
// </SOAP-ENV:Body>
// </SOAP-ENV:Envelope>
// 

?>