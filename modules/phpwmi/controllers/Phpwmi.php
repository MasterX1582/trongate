<?php
class Phpwmi extends Trongate {

	function Test(){  
		$pc = $this->IpAddress();

		$WbemLocator = new COM ("WbemScripting.SWbemLocator");
		$WbemServices = $WbemLocator->ConnectServer($pc, 'root\\cimv2', '<domain_user_name@domain.ext>', '<domain_user_password');
		$WbemServices->Security_->ImpersonationLevel = 3;

		$LogicalDisk =    		$WbemServices->ExecQuery("Select * from Win32_LogicalDisk");
		$Bios =     		 	$WbemServices->ExecQuery("Select * from Win32_BIOS");
		$Processor =    	 	$WbemServices->ExecQuery("Select * from Win32_Processor");
		$PhysicalMemory =    	$WbemServices->ExecQuery("Select * from Win32_PhysicalMemory");
		$BaseBoard =    	 	$WbemServices->ExecQuery("Select * from Win32_BaseBoard");

		foreach ($LogicalDisk as $disk)
		{
			$str=sprintf("%s (%s) %s bytes, %4.1f%% free\n", $disk->Name,$disk->VolumeName,number_format($disk->Size,0,'.',','), $disk->FreeSpace/$disk->Size*100.0);

			echo $str;
		}
		echo "<hr>";
		foreach ($Bios as $Bios)
		{
			echo $Bios->Name;
			echo "<br>";
			echo $Bios->SerialNumber;
			echo "<br>";
			echo $Bios->smbiosbiosversion;			
		}		
		echo "<hr>";
		
		foreach ($Processor as $Processor)
		{
			echo $Processor->Name;
			echo "<br>";
			echo $Processor->SerialNumber;
		}		
		echo "<hr>";		
		var_dump($PhysicalMemory);
		foreach ($PhysicalMemory as $PhysicalMemory)
		{
			echo $PhysicalMemory->SerialNumber;
			echo "<br>";
			echo $PhysicalMemory->Capacity;
			echo "<br>";
			echo $PhysicalMemory->Description;
			echo "<br>";
			echo $PhysicalMemory->Manufacturer;	
			echo "<br>";
			echo $PhysicalMemory->Name;			
			echo "<br>";
			echo $PhysicalMemory->Model;	
			echo "<br>";
			echo $PhysicalMemory->PartNumber;				
		}			
		echo "<hr>";		
		var_dump($BaseBoard);
		echo "<hr>";				
	}
	
	function DiskSize(){  
		$pc = $this->IpAddress();

		$WbemLocator = new COM ("WbemScripting.SWbemLocator");
		$WbemServices = $WbemLocator->ConnectServer($pc, 'root\\cimv2', 'dmoedbe@rockwellautomation.com', 'DellLatitude1118');
		$WbemServices->Security_->ImpersonationLevel = 3;

		$disks =    $WbemServices->ExecQuery("Select * from Win32_LogicalDisk");
		// $pc = "."; 
		// $obj = new COM ("winmgmts:\\\\".$pc."\\root\\cimv2");

		// $disks =  $obj->ExecQuery("Select * from Win32_LogicalDisk");
		foreach ($disks as $d)
		{
			$str=sprintf("%s (%s) %s bytes, %4.1f%% free\n", $d->Name,$d->VolumeName,number_format($d->Size,0,'.',','), $d->FreeSpace/$d->Size*100.0);

			echo $str;
		}
	}
	
	function IpAddress(){
		$pc = $_SERVER['REMOTE_ADDR']; //IP of the PC to manage
		return $pc;
	}	
}