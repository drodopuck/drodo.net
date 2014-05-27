use 5.010;
my $outspace = 0;
my $order;
my $number = 0;

while(<>){
	last if(/"items"/ && $outspace == 1);
	if(/{/){
		$outspace++;
		$count++;
	}
	if(/}/){
		$outspace--;
	}
}

while(<>){
	if(/{/){
		$outspace++;
	}
	if(/}/){
		$outspace--;
		last if($outspace == 2);
	}
}
		
print "{\n";
while(<>){
	 if(/^(\s+)\"\d+\"$/){
	 	if($number != 0){
	 		print "},\n";
	 	}
	 	$number++;
	 	print "$_:{\n";
	 	$order = 0;
	}
	if(/{/){
		$outspace++;
	}
	if(/}/){
		$outspace--;
		last if($outspace == 1);
	}
	if((/item_name/ || /item_rarity/ || /item_description/ || /item_type_name/ || /creation_date/ )&& $outspace == 3){
		chomp;
		$order ++;
		if($order != 1){
			print ",\n";
		}
		$_=~s/\"(\s+)\"/\":\"/;
		print $_;
	}
		if($_=~/used_by_heroes\"$/ && $outspace == 3){
		chomp $_;
		$order ++;
		if($order != 1){
			print ",\n";
		}
		print "$_:";
		<STDIN>;
		$line = <STDIN>;
		$line=~s/\"\s+\".*/\"/;
		print "$line";
		<STDIN>;
	}
}
print "}\n";
print "}";