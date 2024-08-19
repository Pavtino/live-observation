<?php
/**
 * Provides methods to interact with users
 *
 * @author Open Dynamics <info@o-dyn.de>
 * @name user
 * @version 0.7
 * @package Collabtive
 * @link http://www.o-dyn.de
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License v3 or laterg
 */
class user {
    public $mylog;

    /**
     * Constructor
     * Initializes event log
     */
    function __construct()
    {
       // $this->mylog = new mylog;
    }

    /**
     * Creates a user
     *
     * @param string $name Name of the member
     * @param string $email E-mail address of the member
     * @param string $company Company of the member
     * @param string $pass Password
     * @param string $locale Localisation
     * @param float $rate Hourly rate
     * @return int $insid ID of the newly created member
     */
    function add($name, $email, $ville,$societe,$prof, $pass,$tel, $role = "")
    {
        global $conn;
        $pass = sha1($pass);
		//uniq Id
		 $dummy = array_merge(range('0', '9'), range('a', 'z'), range('A', 'Z'), range('0', '9'));
            shuffle($dummy);
            mt_srand((double)microtime() * 1000000);
            $uid = "";
            for ($i = 1; $i <= 10; $i++) {
                $swap = mt_rand(0, count($dummy)-1);
                $tmp = $dummy[$swap];
                $uid .= $tmp;
            }
		//unique ID
		
	$ins1Stmt = $conn->prepare("INSERT INTO user (name,email,ville,societe,pass,prof,tel,role,uid) VALUES (?,?, ?, ?, ?, ?, ?,?,?)");
		$ins1 = $ins1Stmt->execute(array($name, $email, $ville,$societe, $pass, $prof,$tel, $role,$uid));

			if ($ins1) {
				//$insid = $conn->lastInsertId();		
				return $uid;
			} else {
				return '';
			}
		
   
    }

    /**
     * Edits a member
     *
     * @param int $id Member ID
     * @param string $name Member name
     * @param string $realname realname
     * @param string $role role
     * @param string $email Email
     * @param string $company Company of the member
     * @param string $zip ZIP-Code
     * @param string $gender Gender
     * @param string $url URL
     * @param string $address1 Adressline1
     * @param string $address2 Addressline2
     * @param string $state State
     * @param string $country Country
     * @param string $locale Localisation
     * @param string $avatar Avatar
     * @return bool
     */
    function edit($id, $name, $email, $ville, $prof, $genre, $tel, $role,$societe)
    {
        global $conn;

            $updStmt = $conn->prepare("UPDATE user SET name=?, email=?,ville=?,prof=?,genre=?, tel=?, role=?,societe=? WHERE ID = ?");
            $upd = $updStmt->execute(array($name, $email,$ville, $prof, $genre,$tel, $role,$societe,$id));

        if ($upd) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Generate a new password and send it to the user's e-mail address
     *
     * @param string $email E-mail address entered by the user
     * @return string
     */
    function resetPassword($email)
    {
        global $conn;

        $user = $conn->query("SELECT ID, email FROM user WHERE email={$conn->quote($email)} LIMIT 1")->fetch();

        if ($user["email"] == $email) {
            $id = $user["ID"];
        }

        if (isset($id)) {
            $dummy = array_merge(range('0', '9'), range('a', 'z'), range('A', 'Z'), range('0', '9'));
            shuffle($dummy);
            mt_srand((double)microtime() * 1000000);
            $newpass = "";
            for ($i = 1; $i <= 10; $i++) {
                $swap = mt_rand(0, count($dummy)-1);
                $tmp = $dummy[$swap];
                $newpass .= $tmp;
            }

            $sha1pass = sha1($newpass);

            $upd = $conn->query("UPDATE user SET `pass` = '$sha1pass' WHERE ID = $id");
            if ($upd) {
                return $newpass;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Change password
     *
     * @param int $id Member ID
     * @param string $oldpass Old password
     * @param string $newpass New password
     * @param string $repeatpass Repetition of the new password
     * @return bool
     */
    function editpass($id, $oldpass, $newpass, $repeatpass)
    {
        global $conn;
        $id = (int) $id;

        if ($newpass != $repeatpass) {
            return false;
        }
        $newpass = sha1($newpass);

        $oldpass = sha1($oldpass);
        $chk = $conn->query("SELECT ID, name FROM user WHERE ID = $id AND pass = {$conn->quote($oldpass)}")->fetch();
        $chk = $chk[0];
        $name = $chk[1];
        if (!$chk) {
            return false;
        }

        $upd = $conn->query("UPDATE user SET pass={$conn->quote($newpass)} WHERE ID = $id");
        if ($upd) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Change password as admin
     *
     * @param int $id User ID
     * @param string $newpass New password
     * @param string $repeatpass Repetition of the new password
     * @return bool
     */
    function admin_editpass($id, $newpass, $repeatpass)
    {
        global $conn;
        $id = (int) $id;

        if ($newpass != $repeatpass) {
            return false;
        }
        $newpass = sha1($newpass);

        $upd = $conn->query("UPDATE user SET pass={$conn->quote($newpass)} WHERE ID = $id");
        if ($upd) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Delete a user
     *
     * @param int $id User ID
     * @return bool
     */
    function del($id)
    {
        global $conn;
        $id = (int) $id;

        $chk = $conn->query("SELECT name FROM user WHERE ID = $id")->fetch();
        $name = $chk[0];

        $del = $conn->query("DELETE FROM user WHERE ID = $id");
        $del7 = $conn->query("DELETE FROM roles_assigned WHERE user = $id");
        if ($del) {
            $this->mylog->add($name, 'user', 3, 0);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get a user profile
     *
     * @param int $id User ID
     * @return array $profile Profile
     */
    function getProfile($id)
    {
        global $conn;
        $id = (int) $id;

        $sel = $conn->query("SELECT * FROM user WHERE ID = $id");
        $profile = $sel->fetch();
        if (!empty($profile)) {
           
            return $profile;
        } else {
            return false;
        }
    }
/*activate user*/
function activate($uid, $pass)
    {
        global $conn;

        if (!$uid) {
            return false;
        }
        $pass = sha1($pass);

        $sel1 = $conn->query("SELECT ID,name,lastlogin,genre,role,active FROM user WHERE uid = '$uid' AND pass = '$pass'");
        $chk = $sel1->fetch();
        if ($chk["ID"] != "") {
            $now = time();
            $_SESSION['userid'] = $chk['ID'];
            $_SESSION['username'] = stripslashes($chk['name']);
            $_SESSION['lastlogin'] = $now;
            $_SESSION['usergenre'] = $chk['genre'];
			$_SESSION['userrole'] = $chk['role'];
			$_SESSION['active'] = $chk['active'];

            $userid = $_SESSION['userid'];
            $seid = session_id();
          
            $upd1 = $conn->query("UPDATE user SET lastlogin = '$now',active=1 WHERE ID = $userid");
            return true;
        } else {
            return false;
        }
    }
    /**
     * Log a user in
     *
     * @param string $user User name
     * @param string $pass Password
     * @return bool
     */
    function login($email, $pass)
    {
        global $conn;

        if (!$email) {
            return false;
        }
        //$email = $conn->quote($email);
        $pass = sha1($pass);

        $sel1 = $conn->query("SELECT ID,name,lastlogin,genre,role,active FROM user WHERE email = '$email' AND pass = '$pass' and active=1");
        $chk = $sel1->fetch();
        if ($chk["ID"] != "") {
           // $rolesobj = new roles();
            $now = time();
            $_SESSION['userid'] = $chk['ID'];
            $_SESSION['username'] = stripslashes($chk['name']);
            $_SESSION['lastlogin'] = $now;
            $_SESSION['usergenre'] = $chk['genre'];
			$_SESSION['userrole'] = $chk['role'];
			$_SESSION['active'] = $chk['active'];
           // $_SESSION["userpermissions"] = $rolesobj->getUserRole($chk["ID"]);

            $userid = $_SESSION['userid'];
            $seid = session_id();
           // $staylogged = getArrayVal($_POST, 'staylogged');

            /*if ($staylogged == 1) {
                setcookie("PHPSESSID", "$seid", time() + 14 * 24 * 3600);
            }*/
            $upd1 = $conn->query("UPDATE user SET lastlogin = '$now' WHERE ID = $userid");
            return true;
        } else {
            return false;
        }
    }
    /**
     * Logout
     *
     * @return bool
     */
    function logout()
    {
       // session_start();
        session_destroy();
        session_unset();
        setcookie("PHPSESSID", "");
        return true;
    }

    /**
     * Get a user's ID
     *
     * @param string $user Username
     * @return int $theid
     */
    function getId($user)
    {
        global $conn;

        $sel = $conn->query("SELECT ID FROM user WHERE name = {$conn->quote($user)}");
        $id = $sel->fetch();
        $id = $id[0];

        $theid = array();

        $theid["ID"] = $id;

        if ($id > 0) {
            return $theid;
        } else {
            return array();
        }
    }
}

function getAllUsers($lim = 10)
    {
        global $conn;

        $lim = (int) $lim;

        $num = $conn->query("SELECT COUNT(*) FROM `user`")->fetch();
        $num = $num[0];
        

        $sel2 = $conn->query("SELECT ID FROM `user` ORDER BY ID DESC LIMIT $start,$lim");

        $users = array();
        while ($user = $sel2->fetch()) {
            array_push($users, $this->getProfile($user["ID"]));
        }

        if (!empty($users)) {
            return $users;
        } else {
            return false;
        }
    }

?>