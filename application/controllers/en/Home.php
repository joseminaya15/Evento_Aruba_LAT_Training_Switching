<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper("url");//BORRAR CACHÉ DE LA PÁGINA
		$this->load->model('M_Datos');
		$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
        $this->output->set_header('Pragma: no-cache');
	}

	public function index()
	{
		$this->load->view('en/v_home');
	}

	function register(){
		$data['error'] = EXIT_ERROR;
      	$data['msj']   = null;
		try {
			$name           = $this->input->post('Name');
			$surname 		= $this->input->post('Surname');
			$correo 		= $this->input->post('Email');
			$telefono	    = $this->input->post('Phone');
			$empresa 		= $this->input->post('Company');
			$cargo 		    = $this->input->post('Position');
			$pais	 		= $this->input->post('Country');
			$existe         = $this->M_Datos->existCorreo($correo);
			$fecha          = date('Y-m-d');
			if(count($existe) != 0) {
				$data['msj']   = 'Registered mail';
			}
			else{
				$insertParticipante = array('nombre'    => $name,
										   'apellido'   => $surname,
										   'email' 	    => $correo,
										   'telefono' 	=> $telefono,
										   'empresa'    => $empresa,
										   'cargo'      => $cargo,
										   'pais'       => $pais,
										   'fecha'      => $fecha);
				$datoInsert  = $this->M_Datos->insertarDatos($insertParticipante,'participante');
				$this->sendConfirmation($correo);
	          	$data['msj']   = $datoInsert['msj'];
	          	$data['error'] = $datoInsert['error'];
	          }
		} catch(Exception $ex) {
			$data['msj'] = $ex->getMessage();
		}
      	echo json_encode($data);
	}
	function sendConfirmation($correo){
		$data['error'] = EXIT_ERROR;
		$data['msj']   = null;
		try {  
			$this->load->library("email");
			$configGmail = array('protocol'  => 'smtp',
			                     'smtp_host' => 'smtpout.secureserver.net',
			                     'smtp_port' => 3535,
			                     'smtp_user' => 'info@marketinghpe.com',
			                     'smtp_pass' => 'hpEmSac$18',
			                     'mailtype'  => 'html',
			                     'charset'   => 'utf-8',
			                     'newline'   => "\r\n");    
			$this->email->initialize($configGmail);
			$this->email->from('confirmacion@arubamarketing.net');
			$this->email->to($correo);
			// $this->email->to('jose.minayac15@gmail.com');
			$this->email->subject('Aruba - Thank you for your confirmation in our training in Miami.');
			$texto = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=600" />
<link rel="icon" type="image/x-icon" href="http://www.arubanetworks.com/wp-content/themes/Aruba2015/aruba.favicon.32.32.ico">
<link rel="apple-touch-icon-precomposed" sizes="16x16" href="http://www.arubanetworks.com/wp-content/themes/Aruba2015/aruba.favicon.16x16.ico">
<title>Aruba a Hewlett Packard Enterprise</title>
<style type="text/css">
body {
	background-color: #FFF;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #000;
	margin: 0 auto
}
img {
	border: none
}
table td {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px
}
a.gray {
	color: #767676
}
a.white {
	color: #FFF;
	text-decoration: none
}
</style>
</head>
<body>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="border: solid 1px #ccc">
  <tbody>
    <tr>
      <td align="right" style="padding:10px 20px 10px 10px; border-bottom:1px solid #CCC"><font style="font-size:12px; color:#767676">Aruba LAT Partner Training | <a class="gray" href="http://www.arubamarketing.net/eblast/lat_switching_training/default_eng.html">web version</a></font></td>
    </tr>
    <tr>
      <td style="background-color:#FFF; padding:20px"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tbody>
            <tr>
              <td width="140"><img src="http://www.arubamarketing.net/eblast/lat_switching_training/img/aruba-logo_137x72px.png" width="135" height="70" alt=""/></td>
            </tr>
          </tbody>
        </table></td>
    </tr>
    <tr>
      <td style="background-color:#FFF"><img src="http://www.arubamarketing.net/eblast/lat_switching_training/img/header.jpg" width="600" height="185" alt=""/></td>
    </tr>
	  <tr>
				<td style="background-color:#FFF; padding:0 20px 20px 20px">
					<table width="560" bgcolor="#ffffff" cellspacing="0" cellpadding="0" border="0" align="center">
						<tr>
							<td>
								<table cellspacing="0" cellpadding="0" border="0" align="center">
									<tr>
										<td width="560" height="20" style="line-height: 0px; font-size: 0px;"><img src="http://welcome.hp-ww.com/img/s.gif" width="1" height="20" style="display: block;"></td>
									</tr>
									<tr>
										<td align="left" style="padding: 10px">
											<font style="font-family: arial; font-size:28px; line-height:30px; color:#f48120; text-decoration: none;">
											Thank you for your confirmation</font>
										</td>
									</tr>
									<tr>
										<td width="560" height="5" style="line-height: 0px; font-size: 0px;"><img src="http://welcome.hp-ww.com/img/s.gif" width="1" height="10" style="display: block;"></td>
									</tr>
																		<tr>
										<td align="left" style="background-color:#9ed3c8; padding: 10px">
											<font style="font-family: arial; font-size: 19px; color:#FFF; text-decoration: none;">
											Aruba OS &amp; Switching training for LAT Channels<br>
											September 26 al 28, 2018<br>
											Miami, FL											</font></td>
									</tr>
																		<tr>
										<td width="560" height="15" style="line-height: 0px; font-size: 0px;"><img src="http://welcome.hp-ww.com/img/s.gif" width="1" height="15" style="display: block;"></td>
									</tr>
								  <tr>
										<td align="left" style="padding-left: 10px; padding-right: 40px">
										  <font style="font-family: arial; font-size: 16px; color: #646569;">
										    Dear Business Partner:<br>
										    <br>
								          <strong>BOOK YOUR ROOM NOW!</strong> We suggest you to reserve your stay at the designated hotel.<br>
								          <br>
										    Corporate Rate for attendees is $129 per night + 13% taxes
										    (3 week nights during training).<br>
										    <br>
											  Complementary amenities:<br><ul>
												<li style="padding-bottom: 7px">(1) daily breakfast</li>
												<li style="padding-bottom: 7px"><span lang="EN-US">Complementary Parking</span></li>
												<li style="padding-bottom: 7px"><span lang="EN-US">Free Internet (Wi-Fi)</span></li>
												<li style="padding-bottom: 7px">24 Hr. Gym</li>
												<li style="padding-bottom: 7px">All Local Calls, and 1-800 numbers with in the US</li>
											</ul>
											  Your registration includes daily transfers from the hotel to the training room at Ingram Micro facilities, according to the agenda.
									      <br>
										    <br>
									      ¡See you in Miami! </font>
										</td>
									</tr>
													<tr>
                <td height="15" style="line-height: 0px; font-size: 0px;border-bottom:1px solid #CCC"><img src="http://welcome.hp-ww.com/img/s.gif" width="1" height="15" style="display: block;"></td>
              </tr>
									            <tr>
									              <td width="560" height="40" align="left" bgcolor="#f48120"><font style="font-family: arial; font-size: 18px; color: rgb(255, 255, 255); text-decoration: none; font-weight: bold;padding-left: 10px">BOOK YOUR ROOM TODAY!</font></td>
					              </tr>
																						<tr>
                <td height="5" style="line-height: 0px; font-size: 0px;border-bottom:1px solid #CCC"><img src="http://welcome.hp-ww.com/img/s.gif" width="1" height="5" style="display: block;"></td>
              </tr>
									<tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
  
    <tr>
      <td width="138" style="padding: 5px; background: #f5f5f5"><img src="http://www.arubamarketing.net/eblast/lat_switching_training/img/Hotel_Providene_pic.jpg" width="189" height="189" alt=""/></td>
      <td width="422" height="100" valign="middle" style="padding: 15px 15px 15px 15px; background: #f5f5f5"><p><font style="font-family: arial; font-size: 18px; color:#696a6d; line-height: 18px"><b>Hotel Provident Doral At The Blue</b><br>
        </font>
        <font style="font-family: arial; font-size: 14px; color:#696a6d; line-height: 18px">5300 NW 87 Avenue <br>
          Miami, FL, USA, 33178<br>
          <a href="https://www.youtube.com/watch?v=IZH0bs5YJGw&feature=youtu.be">Take the virtual tour </a></font><br>
      </p>
        <p>Make your reservation <a href="https://urldefense.proofpoint.com/v2/url?u=https-3A__gc.synxis.com_rez.aspx-3FHotel-3D62100-26Chain-3D10494-26Dest-3DMIA-26template-3DGCF-26shell-3Ddefault-26start-3Davailresults-26locale-3Den-2DUS-26promo-3DINGR&d=DwMGaQ&c=--1RjWWBW4Kf6aBAaj53vPItwfT0BR1YjSDV46P5EvE&r=hqlRCpF75xJ1-iwc_yi-pFNabiouexLK2hU8SxZHKlE&m=JYH8P1h_G5oC-kIEep2blciyDe5xutwQlYGsXHDEViw&s=qXmvrmb9z8oGzpjh9hqBifk2hvtyn9FNeIfnypbPYCk&e=">here</a></p></td>
      </tr>
   
  </tbody>
</table>
</td>
              </tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
    <tr>
      <td bgcolor="#EFEFEF" align="left" style="padding: 20px 30px; background-color: #EFEFEF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tbody>
            <tr>
              <td style="padding-bottom: 10px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tbody>
                    <tr>
                      <td style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; line-height: 20px; text-align: left; font-weight: bold; color: #f48120;"><a href="http://www.arubanetworks.com/latam/" target="_blank" style="text-decoration: none;"><font color="#f48120">www.arubanetworks.com/latam</font></a></td>
                      <td align="right"><table>
                          <tr>
                            <td width="21" align="left"><a href="http://www.facebook.com/arubanetworks/" target="_blank"><img src="http://www.arubamarketing.net/eblast/lat_switching_training/img/aruba_facebook.png" width="21" height="21" alt="Facebook" border="0" style="display:block; border:0; max-width:21px; max-height:21px;" /></a></td>
                            <td width="21" align="left"><a href="https://twitter.com/intent/follow?source=followbutton&variant=1.0&screen_name=arubanetworks" target="_blank"><img src="http://www.arubamarketing.net/eblast/lat_switching_training/img/aruba_twitter.png" width="21" height="21" alt="Twitter" border="0" style="display:block; border:0; max-width:21px; max-height:21px;" /></a></td>
                            <td width="21" align="left"><a href="https://www.linkedin.com/company/aruba-a-hewlett-packard-enterprise-company" target="_blank"><img src="http://www.arubamarketing.net/eblast/lat_switching_training/img/aruba_linkedin.png" width="21" height="21" alt="LinkedIn" border="0" style="display:block; border:0; max-width:21px; max-height:21px;" /></a></td>
                            <td width="21" align="left"><a href="https://www.youtube.com/user/ArubaNetworks/" target="_blank"><img src="http://www.arubamarketing.net/eblast/lat_switching_training/img/aruba_youtube.png" width="21" height="21" alt="YouTube" border="0" style="display:block; border:0; max-width:21px; max-height:21px;" /></a></td>
                          </tr>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            <tr>
              <td style="font-family: Arial, Helvetica, sans-serif; font-size: 10px; line-height: 14px; text-align: left; color: #A2A2A2;">Hewlett Packard Enterprise respects your privacy. Hewlett Packard Enterprise uses automatic data collection tools to personalize your experience.  If you no longer wish to receive email messages from Hewlett Packard Enterprise containing information and special offers <a  style="color: #000;text-decoration: none;"   href="https://h41360.www4.hpe.com/unsubscribe.php?jumpid=em_qf5dmx9enz&country=WW&language=GB&e=%%=v(@encrypted_email)=%%&pid=%%jobid%%">click here</a>.<br>
                <br>
                For more information about Hewlett Packard’s privacy policies and practices, please review our <a  style="color: #000;text-decoration: none;"   href="http://www8.hp.com/us/en/hpe/privacy/ww-privacy-statements.html?jumpid=em_qf5dmx9enz">Privacy Statement</a>. <br>
                <br>
                To exercise your right to access, correct, object to or delete your data, use the "Privacy Comments Form” available in the Hewlett Packard Personal <a  style="color: #000;text-decoration: none;"   href="http://www8.hp.com/uk/en/hpe/privacy/personal-data-rights.html">Data Rights</a> Notice.<br>
                <br>
                Copyright &copy; 2017. Aruba, a Hewlett Packard Enterprise company. All Rights reserved<br>
                3333 Scott Blvd, Santa Clara, CA 95054, +1.408.227.4500./ 02676.0818</td>
            </tr>
          </tbody>
        </table></td>
    </tr>
  </tbody>
</table>
</body>
</html>';
			$this->email->message($texto);
			$this->email->send();
			$data['error'] = EXIT_SUCCESS;
		}catch (Exception $e){
			$data['msj'] = $e->getMessage();
		}
		return json_encode(array_map('utf8_encode', $data));
	}
}
