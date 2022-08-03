<?php
require 'vendor/autoload.php';

use DOMDocument;
use DOMXPath;
use Selective\XmlDSig\DigestAlgorithmType;
use Selective\XmlDSig\XmlSigner;

$array = array
(
	"AttachedDocument" => Array (
		"ext:UBLExtensions" => Array (
			"ext:UBLExtension" => Array (
				"ext:ExtensionContent" => Array (
				)
			)
		),
		"cbc:UBLVersionID" => "UBL 2.1",
		"cbc:CustomizationID" => "Documentos adjuntos",
		"cbc:ProfileID" => "Factura Electrónica de Venta",
		"cbc:ProfileExecutionID" => 1,
		"cbc:ID" => "7d93eab91f168f5d4be3fcd81617e6d622db2e0cab5b43deec8f",
		"cbc:IssueDate" => "2022-07-11",
		"cbc:IssueTime" => "15:42:49",
		"cbc:DocumentType" => "Contenedor de Factura Electrónica",
		"cbc:ParentDocumentID" => "R20",
		"cac:SenderParty" => Array (
			"cac:PartyTaxScheme" => Array (
				"cbc:RegistrationName" => "BRANDING BOX COMPAÑÍA GRÁFICA SAS",
				"cbc:CompanyID" => 986809,
				"cbc:CompanyID-ATTR" => Array (
					"schemeAgencyID" => "195",
					"schemeID" => "4",
					"schemeName" => "31"
				),
				"cbc:TaxLevelCode" => "O-47;O-23",
				"cac:TaxScheme" => Array (
					"cbc:ID" => "01",
					"cbc:Name" => "IVA"
				)
			)
		),
		"cac:ReceiverParty" => Array (
			"cac:PartyTaxScheme" => Array (
				"cbc:RegistrationName" => "GRUPO INEDITTO SAS",
				"cbc:CompanyID" => 9162935,
				"cbc:CompanyID-ATTR" => Array (
					"schemeAgencyID" => "195",
					"schemeID" => "4",
					"schemeName" => "31"
				),
				"cbc:TaxLevelCode" => "O-15;R-99-PN",
				"cac:TaxScheme" => Array (
					"cbc:ID" => "01",
					"cbc:Name" => "IVA"
				)
			)
		),
		"cac:Attachment" => Array (
			"cac:ExternalReference" => Array (
				"cbc:MimeCode" => "text/xml",
				"cbc:EncodingCode" => "UTF-8",
				"cbc:Description" =>  '<![CDATA[<?xml version="1.0" encoding="utf-8"?>
				<Invoice xsi:schemaLocation="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2 http://docs.oasis-open.org/ubl/os-UBL-2.1/xsd/maindoc/UBL-Invoice-2.1.xsd" xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2" xmlns:sts="dian:gov:co:facturaelectronica:Structures-2-1" xmlns:xades="http://uri.etsi.org/01903/v1.3.2#" xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2" xmlns:n0="urn:oasis:names:specification:ubl:schema:xsd:CommonSignatureComponents-2" xmlns:qdt="urn:oasis:names:specification:ubl:schema:xsd:QualifiedDataTypes-2" xmlns:sac="urn:oasis:names:specification:ubl:schema:xsd:SignatureAggregateComponents-2" xmlns:sbc="urn:oasis:names:specification:ubl:schema:xsd:SignatureBasicComponents-2" xmlns:udt="urn:oasis:names:specification:ubl:schema:xsd:UnqualifiedDataTypes-2" xmlns:ccts-cct="urn:un:unece:uncefact:data:specification:CoreComponentTypeSchemaModule:2" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
				....................
				</cac:TaxTotal>
				<cac:Item>
				<cbc:Description>Suministro de carnet corporativo en pvc americano mas carcasa y yoyo</cbc:Description>
				<cac:StandardItemIdentification>
				<cbc:ID schemeID="999">003</cbc:ID>
				</cac:StandardItemIdentification>
				</cac:Item>
				<cac:Price>
				<cbc:PriceAmount currencyID="COP">18000</cbc:PriceAmount>
				<cbc:BaseQuantity unitCode="94">11</cbc:BaseQuantity>
				</cac:Price>
				</cac:InvoiceLine>
				</Invoice>]]>'
			)
		),
		"cac:ParentDocumentLineReference" => Array (
			"cbc:LineID" => 1,
			"cac:DocumentReference" => Array (
				"cbc:ID" => "R20",
				"cbc:UUID" => "3d87d93eab91f168f5d4be3911ec2d1f9f8ae0cab5b4deec8f",
				"cbc:UUID-ATTR" => Array (
					"schemeName" => "CUFE-SHA384"
				),
				"cbc:IssueDate" => "2022-07-11",
				"cbc:DocumentType" => "ApplicationResponse",
				"cac:Attachment" => Array (
					"cac:ExternalReference" => Array (
						"cbc:MimeCode" => "text/xml",
						"cbc:EncodingCode" => "UTF-8",
						"cbc:Description" => '<![CDATA[<?xml version="1.0" encoding="utf-8" standalone="no"?><ApplicationResponse xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2" xmlns:sts="dian:gov:co:facturaelectronica:Structures-2-1" xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns="urn:oasis:names:specification:ubl:schema:xsd:ApplicationResponse-2">
							<ext:UBLExtensions>
							<ext:UBLExtension>
							<ext:ExtensionContent>
							<sts:DianExtensions>
							<sts:InvoiceSource>
							<cbc:IdentificationCode listAgencyID="6" listAgencyName="United Nations Economic Commission for Europe" listSchemeURI="urn:oasis:names:specification:ubl:codelist:gc:CountryIdentificationCode-2.1">CO</cbc:IdentificationCode>
							</sts:InvoiceSource>
							<sts:SoftwareProvider>
							<sts:ProviderID schemeID="4" schemeName="31" schemeAgencyID="195" schemeAgencyName="CO, DIAN (Direcci�n de Impuestos y Aduanas Nacionales)">800197268</sts:ProviderID>
							......................
							</cac:Response>
							</cac:LineResponse>
							<cac:LineResponse>
							<cac:LineReference>
							<cbc:LineID>2</cbc:LineID>
							</cac:LineReference>
							<cac:Response>
							<cbc:ResponseCode>0</cbc:ResponseCode>
							<cbc:Description>La Factura electr�nica R-20, ha sido autorizada.</cbc:Description>
							</cac:Response>
							</cac:LineResponse>
							</cac:DocumentResponse>
							</ApplicationResponse>]]>'
					)
				),
				"cac:ResultOfVerification" => Array (
					"cbc:ValidatorID" => "Unidad Especial Dirección de Impuestos y Aduanas Nacionales",
					"cbc:ValidationResultCode" => "002",
					"cbc:ValidationDate" => "2022-07-11",
					"cbc:ValidationTime" => "15:41:15"
				)
			)
		)
	),
	"AttachedDocument-ATTR" => Array (
		"xsi:schemaLocation" => "urn:oasis:names:specification:ubl:schema:xsd:AttachedDocument-2 http://docs.oasis-open.org/ubl/os-UBL-2.1/xsd/maindoc/UBL-AttachedDocument-2.1.xsd",
		"xmlns" => "urn:oasis:names:specification:ubl:schema:xsd:AttachedDocument-2",
		"xmlns:xades" => "http://uri.etsi.org/01903/v1.3.2#",
		"xmlns:ds" => "http://www.w3.org/2000/09/xmldsig#",
		"xmlns:cac" => "urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2",
		"xmlns:cbc" => "urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2",
		"xmlns:ext" => "urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2",
		"xmlns:n1" => "urn:oasis:names:specification:ubl:schema:xsd:CommonSignatureComponents-2",
		"xmlns:qdt" => "urn:oasis:names:specification:ubl:schema:xsd:QualifiedDataTypes-2",
		"xmlns:sac" => "urn:oasis:names:specification:ubl:schema:xsd:SignatureAggregateComponents-2",
		"xmlns:sbc" => "urn:oasis:names:specification:ubl:schema:xsd:SignatureBasicComponents-2",
		"xmlns:udt" => "urn:oasis:names:specification:ubl:schema:xsd:UnqualifiedDataTypes-2",
		"xmlns:ccts-cct" => "urn:un:unece:uncefact:data:specification:CoreComponentTypeSchemaModule:2",
		"xmlns:xsi" => "http://www.w3.org/2001/XMLSchema-instance"
	)
);

class XmlBuilder {
	/**
	 * Parse multidimentional array to XML.
	 *
	 * @param array $array
	 * @return string	XML
	 */
	var $xmlContent;

	var $xml;
    	
	function array2xml($array){
		$this->xml = new DOMDocument('1.0', 'utf-8');
		$this->xml->preserveWhiteSpace = true;
		$this->xml->formatOutput = false;
		$this->array_transform($array, $this->xml);
		$this->xmlContent = $this->xml->saveXML();
		return $this->xml;		
	}

	public function save($src){
		$fh = @fopen($src, 'w');
		if($fh){
			$this->xmlContent = $this->xml->saveXML();
			fwrite($fh, $this->xmlContent);
			fclose($fh);
			return true;
		}else {
			return false;
		}
	}

	private function array_transform($array, $xml_parent) {
		foreach($array as $key => $value){
			if(!is_array($value)){
				if(preg_match("/^[0-9]\$/",$key)) $key = "n$key";
				$xml_child = $this->xml->createElement($key, $value);
				if(is_array($array[$key."-ATTR"])){
					foreach ($array[$key."-ATTR"] as $atrkey => $atrval ) 
						$xml_child->setAttribute($atrkey, $atrval);
				}
				$xml_parent->appendChild($xml_child);
			} else {
				if(!preg_match("/(-ATTR)\$/", $key)) {
					if(preg_match("/^[0-9]\$/",$key)) $keyval = "n$key"; else $keyval = $key;
					$xml_child = $this->xml->createElement($keyval);
					$xml_parent->appendChild($xml_child);
					if(is_array($array[$key."-ATTR"])){
						foreach ($array[$key."-ATTR"] as $atrkey => $atrval ) 
							$xml_child->setAttribute($atrkey, $atrval);
					}
					$this->array_transform($value, $xml_child);
				}
			}
		}
	}

	public function sign()   
	{
		$xmlSigner = new XmlSigner();
		$xmlSigner->loadPfxFile('901162935 GRUPO INEDITTO.pfx', '901162935');
		$xmlSigner->setReferenceUri('');
		$xmlSigner->sign($this->xml, DigestAlgorithmType::SHA512);
	}

	function appendCdata($appendToNode, $text)
	{
		if (strtolower($appendToNode->nodeName) == 'script') {  // Javascript hack
			$cm = $appendToNode->ownerDocument->createTextNode("\n//");
			$ct = $appendToNode->ownerDocument->createCDATASection("\n" . $text . "\n//");
			$appendToNode->appendChild($cm);
			$appendToNode->appendChild($ct);
		} else {  // Normal CDATA node
			$ct = $appendToNode->ownerDocument->createCDATASection($text);
			$appendToNode->appendChild($ct);
		}
	}
}

$xmlbuilder = new XmlBuilder();
$xmlbuilder->array2xml($array, true);
$xmlbuilder->sign();
$xmlbuilder->save("result.xml", false);

?>