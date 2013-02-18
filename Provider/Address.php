<?php

namespace Astina\Bundle\SolvencyBundle\Provider;

class Address implements AddressInterface
{
    protected $id;

    protected $title;

    protected $firstName;

    protected $lastName;

    protected $company;

    protected $street;

    protected $zipCode;

    protected $city;

    protected $country;

    protected $poBox;

    protected $emailAddress;

    protected $phoneNumber;

    public function __toString()
    {
        $parts = array();
        $parts[] = ($this->title ? $this->title . ' ' : '') . $this->getFullName();
        if ($this->street) { $parts[] = $this->street; }
        if ($this->getZipCity()) { $parts[] = $this->getZipCity(); }
        if ($this->country) { $parts[] = $this->country; }

        return implode(', ', $parts);
    }

    public function copyTo(AddressInterface $address)
    {
        $address->setTitle($this->title);
        $address->setFirstName($this->firstName);
        $address->setLastName($this->lastName);
        $address->setCompany($this->company);
        $address->setStreet($this->street);
        $address->setZipCode($this->zipCode);
        $address->setCity($this->city);
        $address->setCountry($this->country);
        $address->setPoBox($this->poBox);
        $address->setEmailAddress($this->emailAddress);
        $address->setPhoneNumber($this->phoneNumber);
    }

    public function equals(AddressInterface $address)
    {
        return $this->title == $address->getTitle()
            && $this->firstName == $address->getFirstName()
            && $this->lastName == $address->getLastName()
            && $this->company == $address->getCompany()
            && $this->street == $address->getStreet()
            && $this->zipCode == $address->getZipCode()
            && $this->country == $address->getCountry()
            && $this->poBox == $address->getPoBox()
            && $this->emailAddress == $address->getEmailAddress()
            && $this->phoneNumber == $address->getPhoneNumber();
    }

    public function isEmpty()
    {
        return $this->title == null
            && $this->firstName == null
            && $this->lastName == null
            && $this->company == null
            && $this->street == null
            && $this->zipCode == null
            && $this->country == null
            && $this->poBox == null
            && $this->emailAddress == null
            && $this->phoneNumber == null;

    }

    /**
     * @param \Astina\Bundle\ShopBundle\Model\OrderAddress $shopAddress
     * @return \Astina\Bundle\SolvencyBundle\Provider\Address
     */
    public static function createFromShopAddress($shopAddress)
    {
        $address = new Address();
        $address->setTitle($shopAddress->getTitle());
        $address->setFirstName($shopAddress->getFirstName());
        $address->setLastName($shopAddress->getLastName());
        $address->setCompany($shopAddress->getCompany());
        $address->setStreet($shopAddress->getStreet());
        $address->setZipCode($shopAddress->getZipCode());
        $address->setCity($shopAddress->getCity());
        $address->setCountry($shopAddress->getCountry());
        $address->setPoBox($shopAddress->getPoBox());
        $address->setEmailAddress($shopAddress->getEmailAddress());
        $address->setPhoneNumber($shopAddress->getPhoneNumber());

        return $address;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setCompany($company)
    {
        $this->company = $company;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function setStreet($street)
    {
        $this->street = $street;
    }

    public function getStreet()
    {
        return $this->street;
    }

    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }

    public function getZipCode()
    {
        return $this->zipCode;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getZipCity()
    {
        return trim(sprintf('%s %s', $this->zipCode, $this->city));
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setPoBox($poBox)
    {
        $this->poBox = $poBox;
    }

    public function getPoBox()
    {
        return $this->poBox;
    }

    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;
    }

    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    public function getFullName()
    {
        return trim(sprintf('%s %s', $this->firstName, $this->lastName));
    }
}
