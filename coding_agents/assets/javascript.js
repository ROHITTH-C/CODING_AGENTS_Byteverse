const visibilityBtn=document.getElementById("visibilityBtn")
visibilityBtn.addEventListener("click",toggle)
function toggle(){
    const pw=document.getElementById("password-3")
    const icon= document.getElementById("icon")
    if (pw.type === "password"){
        pw.type="text"
        icon.innerText="Visibility"
    }else{
        pw.type="password"
        icon.innerText="Visibility_off"
    }
}
const rd=document.getElementsByClassName("button")
rd.addEventListener("click",redirect)
function redirect(){
    location.href="login.html"
}