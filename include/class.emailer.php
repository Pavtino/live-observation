<?php
/**
 * This class provides methods to handle emailing
 *
 * @author Open Dynamics <info@kentnix.com>
 * @name emailer
 * @version 1.0
 * @package kentnix.com
 * @link http://www.kentnix.com
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License v3 or later
 */
class emailer
{
    private $from;
    private $mailsettings;

   


    /**
     * Send an email to a member
     *
     * @param string $to Recipient's email address
     * @param string $subject Subjectline of the mail
     * @param string $text Textbody of the mail, HTML allowed
     * @return bool
     */
    function send_mail($to, $subject, $text)
    {
		//create PHP Mailer object
		$mailer = (object) new PHPmailer();
		//setup PHPMailer
		$mailer->From = "test@kentseyes.com";
		$mailer->Sender = "test@kentseyes.com";
		$mailer->FromName = "test";
		$mailer->AddAddress($to);
		$mailer->Subject = $subject;
		$mailer->Body = $text;
		//send mail as HTML
		$mailer->IsHTML(true);
		//set charset
		$mailer->CharSet = "utf-8";
		//set mailing method... mail, smtp or sendmail
		$mailer->Mailer = "smtp";
		//if it's smtp , set the smtp server
		//if($this->mailsettings["mailmethod"] == "smtp")

			$mailer->Host = "smtp.1and1.com";
			//setup SMTP auth
		
				$mailer->Username = "test@kentseyes.com";
				$mailer->Password = "tototest";
				$mailer->SMTPAuth = true;
		

		//}

        if ($mailer->Send())
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

?>