function reverse(str) {
  let answer = ''
  for(let i=str.length-1; i>=0; i--){
    answer += str[i]
  }
  console.log(answer)
}

reverse('hello');

