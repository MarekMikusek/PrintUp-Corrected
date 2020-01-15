<?php
/**
 * Znajduje liczby, które się nie powtarzają
 *
 * @param $input array Tablica liczb
 * @return array
 */
function findSingle(array $input): array
{
  $values = [];
  $counts = [];
  foreach($input as $value){
      if(!is_numeric($value)){
          continue;
      }
      $keyOfValue = array_search ($value,$values);
      if($keyOfValue !== false){
          $counts[$keyOfValue]++;
      }else{
            $values[]=$value;
            $counts[]=1;
      }
  }
  $singleOcurrences = [];
  foreach($counts as $key=>$count){
      if($count ===1){
              $singleOcurrences[]=$values[$key];
            } 
    }
    return $singleOcurrences;
}

function testFindSingle(){
    
}

print_r(findSingle([1, 2, 3, 4, 1, 2, 3,'uu']));
// Array
// (
//     [0] => 4
// )


print_r(findSingle([11, 21, 33.4, 18, 21, 33.39999, 33.4]));
// Array
// (
//     [0] => 11
//     [1] => 33.39999
//     [2] => 18
// )


