let tc= document.getElementById("tc");
let text="Copyright &copy 2022 - "+ new Date().getFullYear()+" maformation.com";
let cp=document.createElement("div");
cp.innerHTML=text;
cp.style.color="white";
tc.appendChild(cp);
