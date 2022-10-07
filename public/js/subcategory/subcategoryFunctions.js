const subcatgoryExpression = {
    name: /^[a-zA-ZÀ-ÿ0-9\s,]{1,49}$/,
    description: /^[a-zA-ZÀ-ÿ0-9\s,]{1,199}$/,
    justLetters: /^[a-zA-ZÀ-ÿ0-9]$/
}

function validateForm(e){
    switch (e.target.name) {
		case "name":
			validate(
                subcatgoryExpression.name, 
                subcatgoryExpression.justLetters, 
                e.target, 
                e.target.id, 
                'Este campo solo se permiten letras y numeros, con un maximo de 50 letras'
            );
		break;
		case "description":
			validateInputNotRequired(
                subcatgoryExpression.description, 
                subcatgoryExpression.justLetters, 
                e.target, 
                e.target.id, 
                'Este campo solo se permiten letras y numeros, con un maximo de 200 letras'
            );
		break;
	}
}

function validateForm2() {
    $.ajax({

        url: '../app/Http/Controllers/SubcategoryController.php',
        type: 'POST',
    });
}

function initializerEventListener() {
    var inputs = document.querySelectorAll("#formSubcategory input");
    inputs.forEach((input) => {
        if (input.type === "text"){
            input.addEventListener('keyup', validateForm);
            input.addEventListener('blur', validateForm);
        }
    });
}