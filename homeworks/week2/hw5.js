function join(arr, concatStr) {
  if(arr.length === 0){
    return ''
  }
  let result = arr[0]
  for(let i=1; i<arr.length; i++){
    result = result + concatStr + arr[i] 
  }
  return result
}

function repeat(str, times) {
  let result = ''
  for(let i=1; i<=times; i++){
    result += str
  }
  return result
}

console.log(join(['a'], '!'));
console.log(repeat('a', 5));



