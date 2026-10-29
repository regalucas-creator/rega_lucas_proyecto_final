<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <style>
* {
    box-sizing: border-box;  
    margin: 0;
    padding: 0;
}

body {
    font-family: Georgia, 'Times New Roman', Times, serif;
    background: linear-gradient(to right, #728ca7, #374f6e);
    min-height: 100vh;         
    display: flex;             
    justify-content: center;   
    align-items: center;       
    padding: 60px;    
    color: rgb(218, 6, 6);         
    
    
}

body > div {
    background: #ffffff;   
    box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1);  
    border-radius: 30px;                
    padding: 50px;                     
    width: 200%;                         
    max-width: 700px;                    
}

h1 {
    font-size: 50px;       
    font-weight: 1000;     
    color: #222335;        
    margin-bottom: 2rem;   
    text-align: center;    
}

h1 + p {
    font-weight: 1000;  
    text-align: center;
    color: #4454e2;          
    margin-bottom: 2rem;      
}

h1 + p + p {
    font-weight: 1000;  
    text-align: center;
    color: #fd0000;          
    margin-bottom: 2rem;   
}

form {
    display: flex;
    flex-direction: column;   
    gap: 2rem;              
}

fieldset {
    border:  solid #9db1d6;          
    border-radius: 20px;              
    padding: 1rem;                    
}

fieldset:hover {
    border-color: #50588d;   
}

fieldset legend{
    align-items: center;
    text-align: center;
}

legend {
    font-weight: 1000;   
    font-size: 30px;        
    color: #2b305f;          
    padding: 1rem;       
    display: flex;
    align-items: center;                   
}

fieldset > div {
    margin-bottom: 2rem;    
}

label {
    display: block;          
    font-weight: 1000;       
    font-size: 15px;
    color: #47435a;          
    margin-bottom: 0.5rem;   
    cursor: pointer;         
}

input[type="text"],
input[type="email"], 

input[type="password"],
select,
textarea {
    width: 50%;                       
    padding: 0.4rem 0.5rem;           
    border: solid #cbd5e1;        
    border-radius: 12px;              
    font-family: Georgia, 'Times New Roman', Times, serif;             
    background: #ffffff;          
    
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus,
select:focus,
textarea:focus {
    border-color: #14488b;                      
    background: rgb(223, 223, 223);                            
}

input::placeholder,
textarea::placeholder {
    color: #6b85aa60;      
    font-style: Georgia, 'Times New Roman', Times, serif;  
}

select {
    appearance: none;
    padding-right: 0.5rem;                   
    cursor: pointer;
    font-style: Georgia, 'Times New Roman', Times, serif;
}

input[type="radio"],
input[type="checkbox"] {
    appearance: none;              
    width: 20px;
    height: 20px;
    border: 1px solid #83a7ac;              
    vertical-align: middle;        
    cursor: pointer;               
}

input[type="radio"] {
    border-radius: 70%;           
}

input[type="checkbox"] {
    border-radius: 7px;
}

input[type="radio"]:checked {
    box-shadow: inset 0 0 0 4px #00ffaa;  
}

input[type="checkbox"]:checked {
    border-color: #15ff00; 
    background: #15ff00;
    
}

input[type="radio"]:hover,
input[type="checkbox"]:hover {
    border-color: #48f803;   
}

fieldset > div > div {
    display: flex;
    flex-wrap: wrap;              
    gap: 1rem 2rem;           
}

fieldset > div > div label {
    display: inline-flex;         
    align-items: center;          
    cursor: pointer;
    padding: 0.4rem 0.75rem;      
    border-radius: 30px;         
    background: #f1f5f9;          

}

fieldset > div > div label:has(input:checked) {
    border-color: #4f46e5;        
    color: #4f46e5;                
}


button {
    font-family: Georgia, 'Times New Roman', Times, serif;      
    font-weight: 1000;            
    padding: 0.4rem 2rem;        
    border: none;
    border-radius: 20px;           
    cursor: pointer;               
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

button[type="submit"] {
    background: #0d83d1ff;           
    color: red;               
}

button[type="submit"]:hover {
    background: #0d83d1ff;                          
    transform: translateY(-4px);                      
}

button[type="submit"]:active {
    transform: translateY(0);                          
}


button[type="reset"] {
    color: #64748b;               
}


button[type="reset"]:hover {
    color: #1e293b;                
    transform: translateY(-4px);   
}


button[type="reset"]:active {
    transform: translateY(0);      
}


input:valid:not(:placeholder-shown):not([type="radio"]):not([type="checkbox"]) {
    border-color: #0077ff;         
}


input:invalid:not(:placeholder-shown):not(:focus):not([type="radio"]):not([type="checkbox"]) {
    border-color: #ff0000;         
}



label:has(+ input[required])::after,
label:has(+ select[required])::after {
    content: ' *';     
    color: #ff0000;       
    font-weight: 1000;     
}



@media (max-width: 600px) { 
    body {
        padding: 1rem; 
    }

body > div {
        padding: 1.5rem;           
        border-radius: 16px;       
    }

    h1 {
        font-size: 1.5rem;         
    }

    fieldset {
        padding: 1rem;             
    }

    
    fieldset > div > div {
        flex-direction: column;    
        gap: 0.5rem;
    }

    
    form > div:last-child {
        flex-direction: column;
        align-items: center;
    }

    button {
        max-width: 100% !important; 
        width: 100%;
    }
}


:focus-visible {
    outline: 2px solid #4f46e5;   
    outline-offset: 2px;          
}
    </style>
</head>

<body>



<div> 
<h1>Registrarse </h1>




<form action="#" method="POST" id="registroForm">



<fieldset>
        <legend>Datos Personales</legend>



<div>
    <label for="nombre">Nombre </label>
    <input type="text" id="nombre" name="nombre" placeholder="Ej: Juan " required>
</div>

<div>
    <label for="Correo electrónico">Correo electrónico </label>
    <input type="email" id="Correo electrónico" name="Correo electrónico" placeholder="Ej: xxxxxxx@gmail.com " required>
</div>


<div>
    <label for="Contraseña">Contraseña </label>
    <input type="password" id="Contraseña" name="Contraseña" placeholder="12345678 " required>
</div>

<div>
    <label for="Repetir Contraseña">Repetir Contraseña </label>
    <input type="password" id="Repetir Contraseña" name="Repetir Contraseña" placeholder="12345678 " required>
</div>




    
            
            <div>
                <button type="submit"><a href="inicio.html">Registrarse</a></button>
                
            </div>
        
            <div>
                <label>
                    <input type="checkbox" name="terminos" required>
                    Acepto los <a href="#">términos y condiciones</a> 
                </label>
            </div>



            </fieldset>

</form>



</body>
</html>
