$i:1;
$length:13;
@while $i <= $length{
	#tab#{$i}:checked{
		~ .tabarea1 .tab#{$i}_label{background:#fff; color:#000;}
		~ .panel_area #panel#{$i}{display:block;}
	}
	$i:$i + 1;
}