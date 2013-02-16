<?php

namespace Astina\Bundle\SolvencyBundle\Provider;

interface AddressInterface
{
    public function __toString();

    public function copyTo(AddressInterface $address);

    public function equals(AddressInterface $address);

    public function isEmpty();

    public function setTitle($title);

    public function getTitle();

    public function setFirstName($firstName);

    public function getFirstName();

    public function setLastName($lastName);

    public function getLastName();

    public function setCompany($company);

    public function getCompany();

    public function setStreet($street);

    public function getStreet();

    public function setZipCode($zipCode);

    public function getZipCode();

    public function setCity($city);

    public function getCity();

    public function getZipCity();

    public function setCountry($country);

    public function getCountry();

    public function setPoBox($poBox);

    public function getPoBox();

    public function setPhoneNumber($phoneNumber);

    public function getPhoneNumber();

    public function setEmailAddress($emailAddress);

    public function getEmailAddress();

    public function getFullName();
}
