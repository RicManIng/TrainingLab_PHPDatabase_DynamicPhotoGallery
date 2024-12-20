window.onload = function(){
    flatpickr("#birth-date", {
        dateFormat: "Y-m-d",
        allowInput: true
    });

    let inputs = document.querySelectorAll("input");
    let labels = document.querySelectorAll("label");
    
    inputs.forEach((input, index) => {
        input.addEventListener("focus", function(){
            labels[index].classList.add("focused");
        });
        input.addEventListener("blur", function(){
            if(input.value == ""){
                labels[index].classList.remove("focused");
            }
        });
    }); 
}