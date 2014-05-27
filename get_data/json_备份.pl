use 5.010;
my $outspace;
my $order;
my $number = 0;
print "{\n";
while(<>){
	 if(/^\"\d+\"$/){
	 	if($number != 0){
	 		print "},\n";
	 	}
	 	$number++;
	 	print "$_:{\n";
	 	$outspace = 0;
	 	$order = 0;
	}
	if(/{/){
		$outspace++;
	}
	if(/}/){
		$outspace--;
	}
	if((/item_name/ || /item_rarity/ || /item_description/ || /item_type_name/ || /creation_date/ )&& $outspace == 1){
		chomp;
		$order ++;
		if($order != 1){
			print ",\n";
		}
		$_=~s/\"(\s+)\"/\":\"/;
		print $_;
	}
		if($_=~/used_by_heroes\"$/ && $outspace == 1){
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