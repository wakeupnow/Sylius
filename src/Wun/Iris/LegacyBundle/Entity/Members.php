<?php

namespace Wun\Iris\LegacyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Members
 *
 * All this shit is half jacked because Legacy is high as fuck.
 * Especially of note is setting default dates as strings because they can't be null.
 *
 * @ORM\Table(name="members", indexes={@ORM\Index(name="memberType", columns={"memberTypeID"}), @ORM\Index(name="username", columns={"username"}), @ORM\Index(name="lastMonthRankID", columns={"lastMonthRankID"}), @ORM\Index(name="currentRankID", columns={"currentRankID"}), @ORM\Index(name="members_marketingSiteName", columns={"marketingSiteName"})})
 * @ORM\Entity
 */
class Members
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=false)
     */
    private $firstname = '';

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=false)
     */
    private $lastname = '';

    /**
     * @var string
     *
     * @ORM\Column(name="marketingSiteName", type="string", length=255, nullable=true)
     */
    private $marketingsitename = '';

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, nullable=false)
     */
    private $username = '';

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=128, nullable=false)
     */
    private $password = '';

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=4, nullable=false)
     */
    private $salt = '';

    /**
     * @var string
     *
     * @ORM\Column(name="parent", type="string", length=10, nullable=false)
     */
    private $parent = '';

    /**
     * @var string
     *
     * @ORM\Column(name="children", type="text", nullable=false)
     */
    private $children = '';

    /**
     * @var string
     *
     * @ORM\Column(name="children2", type="string", length=100, nullable=false)
     */
    private $children2 = '';

    /**
     * @var string
     *
     * @ORM\Column(name="children2_new", type="string", length=45, nullable=false)
     */
    private $children2New = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="listnumber", type="integer", nullable=false)
     */
    private $listnumber = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="creditcard", type="string", length=4, nullable=false)
     */
    private $creditcard = '';

    /**
     * @var string
     *
     * @ORM\Column(name="creditcardObfuscated", type="string", length=255, nullable=true)
     */
    private $creditcardobfuscated;

    /**
     * @var string
     *
     * @ORM\Column(name="nameOnCard", type="string", length=40, nullable=false)
     */
    private $nameoncard = '';

    /**
     * @var string
     *
     * @ORM\Column(name="ccexp", type="string", length=5, nullable=false)
     */
    private $ccexp = '';

    /**
     * @var string
     *
     * @ORM\Column(name="ccZip", type="string", length=25, nullable=false)
     */
    private $cczip = '';

    /**
     * @var string
     *
     * @ORM\Column(name="creditcardtwo", type="string", length=4, nullable=false)
     */
    private $creditcardtwo = '';

    /**
     * @var string
     *
     * @ORM\Column(name="cctokentwo", type="string", length=12, nullable=false)
     */
    private $cctokentwo = '';

    /**
     * @var string
     *
     * @ORM\Column(name="ccexptwo", type="string", length=5, nullable=false)
     */
    private $ccexptwo = '';

    /**
     * @var string
     *
     * @ORM\Column(name="address1", type="string", length=255, nullable=false)
     */
    private $address1 = '';

    /**
     * @var string
     *
     * @ORM\Column(name="address2", type="string", length=255, nullable=false)
     */
    private $address2 = '';

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=false)
     */
    private $city = '';

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=100, nullable=false)
     */
    private $state = '';

    /**
     * @var string
     *
     * @ORM\Column(name="zip", type="string", length=25, nullable=false)
     */
    private $zip = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="country_id", type="integer", nullable=false)
     */
    private $countryId = 1;

    /**
     * @var string
     *
     * @ORM\Column(name="businessName", type="string", length=65, nullable=false)
     */
    private $businessname = '';

    /**
     * @var string
     *
     * @ORM\Column(name="shipping1", type="string", length=255, nullable=false)
     */
    private $shipping1 = '';

    /**
     * @var string
     *
     * @ORM\Column(name="shipping2", type="string", length=255, nullable=false)
     */
    private $shipping2 = '';

    /**
     * @var string
     *
     * @ORM\Column(name="shippingCity", type="string", length=255, nullable=false)
     */
    private $shippingcity = '';

    /**
     * @var string
     *
     * @ORM\Column(name="shippingState", type="string", length=100, nullable=false)
     */
    private $shippingstate = '';

    /**
     * @var string
     *
     * @ORM\Column(name="shippingZip", type="string", length=15, nullable=false)
     */
    private $shippingzip = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="shippingCountryID", type="integer", nullable=false)
     */
    private $shippingcountryid = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="phone2", type="string", length=25, nullable=false)
     */
    private $phone2 = '';

    /**
     * @var string
     *
     * @ORM\Column(name="email2", type="string", length=255, nullable=false)
     */
    private $email2 = '';

    /**
     * @var string
     *
     * @ORM\Column(name="dob", type="string", nullable=false)
     */
    private $dob = '0000-00-00';

    /**
     * @var string
     *
     * @ORM\Column(name="idnum", type="string", length=30, nullable=false)
     */
    private $idnum = '';

    /**
     * @var string
     *
     * @ORM\Column(name="ein", type="string", length=30, nullable=false)
     */
    private $ein = '';

    /**
     * @var string
     *
     * @ORM\Column(name="autoship", type="string", length=1, nullable=false)
     */
    private $autoship = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="autoshipday", type="integer", nullable=false)
     */
    private $autoshipday = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=30, nullable=false)
     */
    private $phone = '';

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email = '';

    /**
     * @var string
     *
     * @ORM\Column(name="balance", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $balance = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="paywithbalance", type="boolean", nullable=false)
     */
    private $paywithbalance = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="signupdate", type="integer", nullable=false)
     */
    private $signupdate = 0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="enrollDateTime", type="datetime", nullable=false)
     */
    private $enrolldatetime = '0000-00-00 00:00:00';

    /**
     * @var string
     *
     * @ORM\Column(name="lastloggedin", type="string", length=15, nullable=false)
     */
    private $lastloggedin = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="forcerank", type="integer", nullable=false)
     */
    private $forcerank = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="package", type="string", length=12, nullable=false)
     */
    private $package = '';

    /**
     * @var string
     *
     * @ORM\Column(name="productOptions", type="string", length=35, nullable=false)
     */
    private $productoptions = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="specialstatus", type="integer", nullable=false)
     */
    private $specialstatus = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="payeraccountid", type="string", length=30, nullable=false)
     */
    private $payeraccountid = '';

    /**
     * @var string
     *
     * @ORM\Column(name="paymentmethodid", type="string", length=65, nullable=false)
     */
    private $paymentmethodid = '';

    /**
     * @var boolean
     *
     * @ORM\Column(name="displayAlertMessage", type="boolean", nullable=false)
     */
    private $displayalertmessage = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="ccType", type="string", length=15, nullable=false)
     */
    private $cctype = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="leftLeg", type="integer", nullable=false)
     */
    private $leftleg = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="rightLeg", type="integer", nullable=false)
     */
    private $rightleg = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activeStatus", type="boolean", nullable=false)
     */
    private $activestatus = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="paymentType", type="boolean", nullable=false)
     */
    private $paymenttype = 1;

    /**
     * @var string
     *
     * @ORM\Column(name="dateTimeCancelled", type="string", nullable=false)
     */
    private $datetimecancelled = '0000-00-00 00:00:00';

    /**
     * @var boolean
     *
     * @ORM\Column(name="newAcctInfoExported", type="boolean", nullable=false)
     */
    private $newacctinfoexported = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="defaultLanguage", type="string", length=5, nullable=false)
     */
    private $defaultlanguage = 'eng';

    /**
     * @var string
     *
     * @ORM\Column(name="dateToAddToMatrugen", type="string", nullable=false)
     */
    private $datetoaddtomatrugen = '0000-00-00 00:00:00';

    /**
     * @var boolean
     *
     * @ORM\Column(name="masterDistributor", type="boolean", nullable=false)
     */
    private $masterdistributor = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="memberTypeID", type="integer", nullable=false)
     */
    private $membertypeid = 1;

    /**
     * @var boolean
     *
     * @ORM\Column(name="compressed", type="boolean", nullable=false)
     */
    private $compressed = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="demoAcct", type="boolean", nullable=false)
     */
    private $demoacct = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="lastLogin", type="string", nullable=false)
     */
    private $lastlogin = '0000-00-00 00:00:00';

    /**
     * @var boolean
     *
     * @ORM\Column(name="highestRankID", type="boolean", nullable=false)
     */
    private $highestrankid = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="lastMonthRankID", type="boolean", nullable=false)
     */
    private $lastmonthrankid = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="currentRankID", type="boolean", nullable=false)
     */
    private $currentrankid = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="preLaunch", type="boolean", nullable=false)
     */
    private $prelaunch = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="salutation", type="integer", nullable=false)
     */
    private $salutation = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="enrollIP", type="string", length=15, nullable=false)
     */
    private $enrollip = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="silverLiteInventoryLimit", type="integer", nullable=false)
     */
    private $silverliteinventorylimit = 375;

    /**
     * @var integer
     *
     * @ORM\Column(name="enrollSource", type="integer", nullable=true)
     */
    private $enrollsource = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="suspended", type="boolean", nullable=false)
     */
    private $suspended = 0;



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->enrolldatetime = new \DateTime("now");
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return Members
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return Members
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return Members
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set marketingsitename
     *
     * @param string $marketingsitename
     * @return Members
     */
    public function setMarketingsitename($marketingsitename)
    {
        $this->marketingsitename = $marketingsitename;

        return $this;
    }

    /**
     * Get marketingsitename
     *
     * @return string 
     */
    public function getMarketingsitename()
    {
        return $this->marketingsitename;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return Members
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Members
     */
    public function setPassword($password)
    {
        $this->password = hash("sha512", $this->getSalt().hash("sha512", $password));

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @return Members
     */
    public function setSalt()
    {
        $this->salt = substr(md5(uniqid(rand(), true)), 0, 4);

        return $this;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set parent
     *
     * @param string $parent
     * @return Members
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return string 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set children
     *
     * @param string $children
     * @return Members
     */
    public function setChildren($children)
    {
        $this->children = $children;

        return $this;
    }

    /**
     * Get children
     *
     * @return string 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set children2
     *
     * @param string $children2
     * @return Members
     */
    public function setChildren2($children2)
    {
        $this->children2 = $children2;

        return $this;
    }

    /**
     * Get children2
     *
     * @return string 
     */
    public function getChildren2()
    {
        return $this->children2;
    }

    /**
     * Set children2New
     *
     * @param string $children2New
     * @return Members
     */
    public function setChildren2New($children2New)
    {
        $this->children2New = $children2New;

        return $this;
    }

    /**
     * Get children2New
     *
     * @return string 
     */
    public function getChildren2New()
    {
        return $this->children2New;
    }

    /**
     * Set listnumber
     *
     * @param integer $listnumber
     * @return Members
     */
    public function setListnumber($listnumber)
    {
        $this->listnumber = $listnumber;

        return $this;
    }

    /**
     * Get listnumber
     *
     * @return integer 
     */
    public function getListnumber()
    {
        return $this->listnumber;
    }

    /**
     * Set creditcard
     *
     * @param string $creditcard
     * @return Members
     */
    public function setCreditcard($creditcard)
    {
        $this->creditcard = $creditcard;

        return $this;
    }

    /**
     * Get creditcard
     *
     * @return string 
     */
    public function getCreditcard()
    {
        return $this->creditcard;
    }

    /**
     * Set creditcardobfuscated
     *
     * @param string $creditcardobfuscated
     * @return Members
     */
    public function setCreditcardobfuscated($creditcardobfuscated)
    {
        $this->creditcardobfuscated = $creditcardobfuscated;

        return $this;
    }

    /**
     * Get creditcardobfuscated
     *
     * @return string 
     */
    public function getCreditcardobfuscated()
    {
        return $this->creditcardobfuscated;
    }

    /**
     * Set nameoncard
     *
     * @param string $nameoncard
     * @return Members
     */
    public function setNameoncard($nameoncard)
    {
        $this->nameoncard = $nameoncard;

        return $this;
    }

    /**
     * Get nameoncard
     *
     * @return string 
     */
    public function getNameoncard()
    {
        return $this->nameoncard;
    }

    /**
     * Set ccexp
     *
     * @param string $ccexp
     * @return Members
     */
    public function setCcexp($ccexp)
    {
        $this->ccexp = $ccexp;

        return $this;
    }

    /**
     * Get ccexp
     *
     * @return string 
     */
    public function getCcexp()
    {
        return $this->ccexp;
    }

    /**
     * Set cczip
     *
     * @param string $cczip
     * @return Members
     */
    public function setCczip($cczip)
    {
        $this->cczip = $cczip;

        return $this;
    }

    /**
     * Get cczip
     *
     * @return string 
     */
    public function getCczip()
    {
        return $this->cczip;
    }

    /**
     * Set creditcardtwo
     *
     * @param string $creditcardtwo
     * @return Members
     */
    public function setCreditcardtwo($creditcardtwo)
    {
        $this->creditcardtwo = $creditcardtwo;

        return $this;
    }

    /**
     * Get creditcardtwo
     *
     * @return string 
     */
    public function getCreditcardtwo()
    {
        return $this->creditcardtwo;
    }

    /**
     * Set cctokentwo
     *
     * @param string $cctokentwo
     * @return Members
     */
    public function setCctokentwo($cctokentwo)
    {
        $this->cctokentwo = $cctokentwo;

        return $this;
    }

    /**
     * Get cctokentwo
     *
     * @return string 
     */
    public function getCctokentwo()
    {
        return $this->cctokentwo;
    }

    /**
     * Set ccexptwo
     *
     * @param string $ccexptwo
     * @return Members
     */
    public function setCcexptwo($ccexptwo)
    {
        $this->ccexptwo = $ccexptwo;

        return $this;
    }

    /**
     * Get ccexptwo
     *
     * @return string 
     */
    public function getCcexptwo()
    {
        return $this->ccexptwo;
    }

    /**
     * Set address1
     *
     * @param string $address1
     * @return Members
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;

        return $this;
    }

    /**
     * Get address1
     *
     * @return string 
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * Set address2
     *
     * @param string $address2
     * @return Members
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;

        return $this;
    }

    /**
     * Get address2
     *
     * @return string 
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Members
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return Members
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set zip
     *
     * @param string $zip
     * @return Members
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip
     *
     * @return string 
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set countryId
     *
     * @param integer $countryId
     * @return Members
     */
    public function setCountryId($countryId)
    {
        $this->countryId = $countryId;

        return $this;
    }

    /**
     * Get countryId
     *
     * @return integer 
     */
    public function getCountryId()
    {
        return $this->countryId;
    }

    /**
     * Set businessname
     *
     * @param string $businessname
     * @return Members
     */
    public function setBusinessname($businessname)
    {
        $this->businessname = $businessname;

        return $this;
    }

    /**
     * Get businessname
     *
     * @return string 
     */
    public function getBusinessname()
    {
        return $this->businessname;
    }

    /**
     * Set shipping1
     *
     * @param string $shipping1
     * @return Members
     */
    public function setShipping1($shipping1)
    {
        $this->shipping1 = $shipping1;

        return $this;
    }

    /**
     * Get shipping1
     *
     * @return string 
     */
    public function getShipping1()
    {
        return $this->shipping1;
    }

    /**
     * Set shipping2
     *
     * @param string $shipping2
     * @return Members
     */
    public function setShipping2($shipping2)
    {
        $this->shipping2 = $shipping2;

        return $this;
    }

    /**
     * Get shipping2
     *
     * @return string 
     */
    public function getShipping2()
    {
        return $this->shipping2;
    }

    /**
     * Set shippingcity
     *
     * @param string $shippingcity
     * @return Members
     */
    public function setShippingcity($shippingcity)
    {
        $this->shippingcity = $shippingcity;

        return $this;
    }

    /**
     * Get shippingcity
     *
     * @return string 
     */
    public function getShippingcity()
    {
        return $this->shippingcity;
    }

    /**
     * Set shippingstate
     *
     * @param string $shippingstate
     * @return Members
     */
    public function setShippingstate($shippingstate)
    {
        $this->shippingstate = $shippingstate;

        return $this;
    }

    /**
     * Get shippingstate
     *
     * @return string 
     */
    public function getShippingstate()
    {
        return $this->shippingstate;
    }

    /**
     * Set shippingzip
     *
     * @param string $shippingzip
     * @return Members
     */
    public function setShippingzip($shippingzip)
    {
        $this->shippingzip = $shippingzip;

        return $this;
    }

    /**
     * Get shippingzip
     *
     * @return string 
     */
    public function getShippingzip()
    {
        return $this->shippingzip;
    }

    /**
     * Set shippingcountryid
     *
     * @param integer $shippingcountryid
     * @return Members
     */
    public function setShippingcountryid($shippingcountryid)
    {
        $this->shippingcountryid = $shippingcountryid;

        return $this;
    }

    /**
     * Get shippingcountryid
     *
     * @return integer 
     */
    public function getShippingcountryid()
    {
        return $this->shippingcountryid;
    }

    /**
     * Set phone2
     *
     * @param string $phone2
     * @return Members
     */
    public function setPhone2($phone2)
    {
        $this->phone2 = $phone2;

        return $this;
    }

    /**
     * Get phone2
     *
     * @return string 
     */
    public function getPhone2()
    {
        return $this->phone2;
    }

    /**
     * Set email2
     *
     * @param string $email2
     * @return Members
     */
    public function setEmail2($email2)
    {
        $this->email2 = $email2;

        return $this;
    }

    /**
     * Get email2
     *
     * @return string 
     */
    public function getEmail2()
    {
        return $this->email2;
    }

    /**
     * Set dob
     *
     * @param string $dob
     * @return Members
     */
    public function setDob($dob)
    {
        $this->dob = $dob;

        return $this;
    }

    /**
     * Get dob
     *
     * @return \DateTime 
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * Set idnum
     *
     * @param string $idnum
     * @return Members
     */
    public function setIdnum($idnum)
    {
        $this->idnum = $idnum;

        return $this;
    }

    /**
     * Get idnum
     *
     * @return string 
     */
    public function getIdnum()
    {
        return $this->idnum;
    }

    /**
     * Set ein
     *
     * @param string $ein
     * @return Members
     */
    public function setEin($ein)
    {
        $this->ein = $ein;

        return $this;
    }

    /**
     * Get ein
     *
     * @return string 
     */
    public function getEin()
    {
        return $this->ein;
    }

    /**
     * Set autoship
     *
     * @param string $autoship
     * @return Members
     */
    public function setAutoship($autoship)
    {
        $this->autoship = $autoship;

        return $this;
    }

    /**
     * Get autoship
     *
     * @return string 
     */
    public function getAutoship()
    {
        return $this->autoship;
    }

    /**
     * Set autoshipday
     *
     * @param integer $autoshipday
     * @return Members
     */
    public function setAutoshipday($autoshipday)
    {
        $this->autoshipday = $autoshipday;

        return $this;
    }

    /**
     * Get autoshipday
     *
     * @return integer 
     */
    public function getAutoshipday()
    {
        return $this->autoshipday;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Members
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Members
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set balance
     *
     * @param string $balance
     * @return Members
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;

        return $this;
    }

    /**
     * Get balance
     *
     * @return string 
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * Set paywithbalance
     *
     * @param boolean $paywithbalance
     * @return Members
     */
    public function setPaywithbalance($paywithbalance)
    {
        $this->paywithbalance = $paywithbalance;

        return $this;
    }

    /**
     * Get paywithbalance
     *
     * @return boolean 
     */
    public function getPaywithbalance()
    {
        return $this->paywithbalance;
    }

    /**
     * Set signupdate
     *
     * @param integer $signupdate
     * @return Members
     */
    public function setSignupdate($signupdate)
    {
        $this->signupdate = $signupdate;

        return $this;
    }

    /**
     * Get signupdate
     *
     * @return integer 
     */
    public function getSignupdate()
    {
        return $this->signupdate;
    }

    /**
     * Set enrolldatetime
     *
     * @param \DateTime $enrolldatetime
     * @return Members
     */
    public function setEnrolldatetime($enrolldatetime)
    {
        $this->enrolldatetime = $enrolldatetime;

        return $this;
    }

    /**
     * Get enrolldatetime
     *
     * @return \DateTime 
     */
    public function getEnrolldatetime()
    {
        return $this->enrolldatetime;
    }

    /**
     * Set lastloggedin
     *
     * @param string $lastloggedin
     * @return Members
     */
    public function setLastloggedin($lastloggedin)
    {
        $this->lastloggedin = $lastloggedin;

        return $this;
    }

    /**
     * Get lastloggedin
     *
     * @return string 
     */
    public function getLastloggedin()
    {
        return $this->lastloggedin;
    }

    /**
     * Set forcerank
     *
     * @param integer $forcerank
     * @return Members
     */
    public function setForcerank($forcerank)
    {
        $this->forcerank = $forcerank;

        return $this;
    }

    /**
     * Get forcerank
     *
     * @return integer 
     */
    public function getForcerank()
    {
        return $this->forcerank;
    }

    /**
     * Set package
     *
     * @param string $package
     * @return Members
     */
    public function setPackage($package)
    {
        $this->package = $package;

        return $this;
    }

    /**
     * Get package
     *
     * @return string 
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * Set productoptions
     *
     * @param string $productoptions
     * @return Members
     */
    public function setProductoptions($productoptions)
    {
        $this->productoptions = $productoptions;

        return $this;
    }

    /**
     * Get productoptions
     *
     * @return string 
     */
    public function getProductoptions()
    {
        return $this->productoptions;
    }

    /**
     * Set specialstatus
     *
     * @param integer $specialstatus
     * @return Members
     */
    public function setSpecialstatus($specialstatus)
    {
        $this->specialstatus = $specialstatus;

        return $this;
    }

    /**
     * Get specialstatus
     *
     * @return integer 
     */
    public function getSpecialstatus()
    {
        return $this->specialstatus;
    }

    /**
     * Set payeraccountid
     *
     * @param string $payeraccountid
     * @return Members
     */
    public function setPayeraccountid($payeraccountid)
    {
        $this->payeraccountid = $payeraccountid;

        return $this;
    }

    /**
     * Get payeraccountid
     *
     * @return string 
     */
    public function getPayeraccountid()
    {
        return $this->payeraccountid;
    }

    /**
     * Set paymentmethodid
     *
     * @param string $paymentmethodid
     * @return Members
     */
    public function setPaymentmethodid($paymentmethodid)
    {
        $this->paymentmethodid = $paymentmethodid;

        return $this;
    }

    /**
     * Get paymentmethodid
     *
     * @return string 
     */
    public function getPaymentmethodid()
    {
        return $this->paymentmethodid;
    }

    /**
     * Set displayalertmessage
     *
     * @param boolean $displayalertmessage
     * @return Members
     */
    public function setDisplayalertmessage($displayalertmessage)
    {
        $this->displayalertmessage = $displayalertmessage;

        return $this;
    }

    /**
     * Get displayalertmessage
     *
     * @return boolean 
     */
    public function getDisplayalertmessage()
    {
        return $this->displayalertmessage;
    }

    /**
     * Set cctype
     *
     * @param string $cctype
     * @return Members
     */
    public function setCctype($cctype)
    {
        $this->cctype = $cctype;

        return $this;
    }

    /**
     * Get cctype
     *
     * @return string 
     */
    public function getCctype()
    {
        return $this->cctype;
    }

    /**
     * Set leftleg
     *
     * @param integer $leftleg
     * @return Members
     */
    public function setLeftleg($leftleg)
    {
        $this->leftleg = $leftleg;

        return $this;
    }

    /**
     * Get leftleg
     *
     * @return integer 
     */
    public function getLeftleg()
    {
        return $this->leftleg;
    }

    /**
     * Set rightleg
     *
     * @param integer $rightleg
     * @return Members
     */
    public function setRightleg($rightleg)
    {
        $this->rightleg = $rightleg;

        return $this;
    }

    /**
     * Get rightleg
     *
     * @return integer 
     */
    public function getRightleg()
    {
        return $this->rightleg;
    }

    /**
     * Set activestatus
     *
     * @param boolean $activestatus
     * @return Members
     */
    public function setActivestatus($activestatus)
    {
        $this->activestatus = $activestatus;

        return $this;
    }

    /**
     * Get activestatus
     *
     * @return boolean 
     */
    public function getActivestatus()
    {
        return $this->activestatus;
    }

    /**
     * Set paymenttype
     *
     * @param boolean $paymenttype
     * @return Members
     */
    public function setPaymenttype($paymenttype)
    {
        $this->paymenttype = $paymenttype;

        return $this;
    }

    /**
     * Get paymenttype
     *
     * @return boolean 
     */
    public function getPaymenttype()
    {
        return $this->paymenttype;
    }

    /**
     * Set datetimecancelled
     *
     * @param string $datetimecancelled
     * @return Members
     */
    public function setDatetimecancelled($datetimecancelled)
    {
        $this->datetimecancelled = $datetimecancelled;

        return $this;
    }

    /**
     * Get datetimecancelled
     *
     * @return \DateTime 
     */
    public function getDatetimecancelled()
    {
        return $this->datetimecancelled;
    }

    /**
     * Set newacctinfoexported
     *
     * @param boolean $newacctinfoexported
     * @return Members
     */
    public function setNewacctinfoexported($newacctinfoexported)
    {
        $this->newacctinfoexported = $newacctinfoexported;

        return $this;
    }

    /**
     * Get newacctinfoexported
     *
     * @return boolean 
     */
    public function getNewacctinfoexported()
    {
        return $this->newacctinfoexported;
    }

    /**
     * Set defaultlanguage
     *
     * @param string $defaultlanguage
     * @return Members
     */
    public function setDefaultlanguage($defaultlanguage)
    {
        $this->defaultlanguage = $defaultlanguage;

        return $this;
    }

    /**
     * Get defaultlanguage
     *
     * @return string 
     */
    public function getDefaultlanguage()
    {
        return $this->defaultlanguage;
    }

    /**
     * Set datetoaddtomatrugen
     *
     * @param string $datetoaddtomatrugen
     * @return Members
     */
    public function setDatetoaddtomatrugen($datetoaddtomatrugen)
    {
        $this->datetoaddtomatrugen = $datetoaddtomatrugen;

        return $this;
    }

    /**
     * Get datetoaddtomatrugen
     *
     * @return \DateTime 
     */
    public function getDatetoaddtomatrugen()
    {
        return $this->datetoaddtomatrugen;
    }

    /**
     * Set masterdistributor
     *
     * @param boolean $masterdistributor
     * @return Members
     */
    public function setMasterdistributor($masterdistributor)
    {
        $this->masterdistributor = $masterdistributor;

        return $this;
    }

    /**
     * Get masterdistributor
     *
     * @return boolean 
     */
    public function getMasterdistributor()
    {
        return $this->masterdistributor;
    }

    /**
     * Set membertypeid
     *
     * @param integer $membertypeid
     * @return Members
     */
    public function setMembertypeid($membertypeid)
    {
        $this->membertypeid = $membertypeid;

        return $this;
    }

    /**
     * Get membertypeid
     *
     * @return integer 
     */
    public function getMembertypeid()
    {
        return $this->membertypeid;
    }

    /**
     * Set compressed
     *
     * @param boolean $compressed
     * @return Members
     */
    public function setCompressed($compressed)
    {
        $this->compressed = $compressed;

        return $this;
    }

    /**
     * Get compressed
     *
     * @return boolean 
     */
    public function getCompressed()
    {
        return $this->compressed;
    }

    /**
     * Set demoacct
     *
     * @param boolean $demoacct
     * @return Members
     */
    public function setDemoacct($demoacct)
    {
        $this->demoacct = $demoacct;

        return $this;
    }

    /**
     * Get demoacct
     *
     * @return boolean 
     */
    public function getDemoacct()
    {
        return $this->demoacct;
    }

    /**
     * Set lastlogin
     *
     * @param string $lastlogin
     * @return Members
     */
    public function setLastlogin($lastlogin)
    {
        $this->lastlogin = $lastlogin;

        return $this;
    }

    /**
     * Get lastlogin
     *
     * @return \DateTime 
     */
    public function getLastlogin()
    {
        return $this->lastlogin;
    }

    /**
     * Set highestrankid
     *
     * @param boolean $highestrankid
     * @return Members
     */
    public function setHighestrankid($highestrankid)
    {
        $this->highestrankid = $highestrankid;

        return $this;
    }

    /**
     * Get highestrankid
     *
     * @return boolean 
     */
    public function getHighestrankid()
    {
        return $this->highestrankid;
    }

    /**
     * Set lastmonthrankid
     *
     * @param boolean $lastmonthrankid
     * @return Members
     */
    public function setLastmonthrankid($lastmonthrankid)
    {
        $this->lastmonthrankid = $lastmonthrankid;

        return $this;
    }

    /**
     * Get lastmonthrankid
     *
     * @return boolean 
     */
    public function getLastmonthrankid()
    {
        return $this->lastmonthrankid;
    }

    /**
     * Set currentrankid
     *
     * @param boolean $currentrankid
     * @return Members
     */
    public function setCurrentrankid($currentrankid)
    {
        $this->currentrankid = $currentrankid;

        return $this;
    }

    /**
     * Get currentrankid
     *
     * @return boolean 
     */
    public function getCurrentrankid()
    {
        return $this->currentrankid;
    }

    /**
     * Set prelaunch
     *
     * @param boolean $prelaunch
     * @return Members
     */
    public function setPrelaunch($prelaunch)
    {
        $this->prelaunch = $prelaunch;

        return $this;
    }

    /**
     * Get prelaunch
     *
     * @return boolean 
     */
    public function getPrelaunch()
    {
        return $this->prelaunch;
    }

    /**
     * Set salutation
     *
     * @param integer $salutation
     * @return Members
     */
    public function setSalutation($salutation)
    {
        $this->salutation = $salutation;

        return $this;
    }

    /**
     * Get salutation
     *
     * @return integer 
     */
    public function getSalutation()
    {
        return $this->salutation;
    }

    /**
     * Set enrollip
     *
     * @param string $enrollip
     * @return Members
     */
    public function setEnrollip($enrollip)
    {
        $this->enrollip = $enrollip;

        return $this;
    }

    /**
     * Get enrollip
     *
     * @return string 
     */
    public function getEnrollip()
    {
        return $this->enrollip;
    }

    /**
     * Set silverliteinventorylimit
     *
     * @param integer $silverliteinventorylimit
     * @return Members
     */
    public function setSilverliteinventorylimit($silverliteinventorylimit)
    {
        $this->silverliteinventorylimit = $silverliteinventorylimit;

        return $this;
    }

    /**
     * Get silverliteinventorylimit
     *
     * @return integer 
     */
    public function getSilverliteinventorylimit()
    {
        return $this->silverliteinventorylimit;
    }

    /**
     * Set enrollsource
     *
     * @param integer $enrollsource
     * @return Members
     */
    public function setEnrollsource($enrollsource)
    {
        $this->enrollsource = $enrollsource;

        return $this;
    }

    /**
     * Get enrollsource
     *
     * @return integer 
     */
    public function getEnrollsource()
    {
        return $this->enrollsource;
    }

    /**
     * Set suspended
     *
     * @param boolean $suspended
     * @return Members
     */
    public function setSuspended($suspended)
    {
        $this->suspended = $suspended;

        return $this;
    }

    /**
     * Get suspended
     *
     * @return boolean 
     */
    public function getSuspended()
    {
        return $this->suspended;
    }
}
