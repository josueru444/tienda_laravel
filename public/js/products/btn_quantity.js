console.log('carrito');
const buttons=document.querySelectorAll('#plus');
const buttonsMinus=document.querySelectorAll('#minus');

function currencyFormat(num) {
    return '$' + num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');}

buttons.forEach(button => {
    button.addEventListener('click',e=>{
       
        let input=document.querySelector('#cantidad');
        let quantity=input.value;
        let max=input.max;
        console.log('d');
        input.value=parseInt(input.value)+1;

        if(parseInt(quantity)>=parseInt(max)){
            input.value=max;
        }

    })
});

buttonsMinus.forEach(button => {
    button.addEventListener('click',e=>{
        
        let input=document.querySelector('#cantidad');
        let quantity=input.value;
        
        input.value=parseInt(input.value)-1;

        if(parseInt(quantity)<=1){
            input.value=1;        
        }

    })
});