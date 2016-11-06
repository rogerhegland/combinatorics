Get array / write file / iterate through all combinations of passed characters with defined length.

# Permutation

## With repetition
`// coming soon`

## Without repetition
`// coming soon`

# Variation

## With repetition
`// coming soon`

## Without repetition
`// coming soon`

# Combination

## With repetition
```php
$combination = new Combination();
$combination->setCharacters('ab')->setSize(2);

$combinations = $combination->get();
// = $combinations = [ 'aa', 'ab', 'ba', 'bb' ]


$combinations = [];
while (( $combination = $combination->next() ) !== false) {
	$combinations[] = $combination;
}
// = $combinations = [ 'aa', 'ab', 'ba', 'bb' ]


$combination->write('combinations.txt', PHP_EOL);
/*
file "combinations.txt" with the following content:
aa
ab
ba
bb
*/
```

## Without repetition
`// coming soon`