<?php
$siadir=shell_exec('source /boot/parameters.txt && echo $SIADIR');
// Only list SCSI HDDs:8. Exclude Ram disks, CD Roms and SD cards:1,11,179
$deviceInfo=shell_exec("sudo lsblk -I 8 -pdJo NAME,SIZE,MODEL");
$FulldeviceInfo=shell_exec("sudo lsblk -I 8 -pJo NAME,SIZE,FSTYPE,PARTTYPE,MOUNTPOINT,UUID,MODEL");
$listD=json_decode($deviceInfo,true);
$FlistD=json_decode($FulldeviceInfo,true);
//echo $listD["blockdevices"][2]["name"]."\n";
//echo $FlistD["blockdevices"][0]["children"][0]["fstype"]."\n";
$numD=count($listD["blockdevices"]);

// An array variable for checking if the main drive is mounted or not.
$IsMounted=array_fill(0,$numD,false);

// Which partition is Sia software on? (remove the leading/trailing whitespaces too)
$SiaPart=trim(shell_exec("bin/SiaPartChecker $siadir"));

// A function to give "sda2" from "/dev/sda2"
function GetDevName ($DevicePath) {
    $DevName=explode('/',$DevicePath);
    return $DevName[2];
}
?>