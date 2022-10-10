import{_,d as w,H as g,V as v,L as b,s as h,k as y,o as m,f as d,b as o,a as t,p as V,g as p,t as j,w as k,n as J,i as x,F as C,r as i}from"./app.f1ef34bf.js";import{J as R,a as L}from"./AuthenticationCardLogo.24f7b7f7.js";import{J as $}from"./Button.c56bed8d.js";import{J as q}from"./Input.4240a7e1.js";import{J as B}from"./Checkbox.b7ebc84e.js";import{J as E}from"./Label.36e42c47.js";const H=w({components:{Head:g,JetAuthenticationCard:R,JetAuthenticationCardLogo:L,JetButton:$,JetInput:q,JetCheckbox:B,JetLabel:E,JetValidationErrors:v,Link:b},props:{invitation:Object},data(){return{form:this.$inertia.form({name:"",password:"",password_confirmation:"",token:this.invitation.invitation_token})}},methods:{submit(){this.form.post("register",{onFinish:()=>this.form.reset("password","password_confirmation")})}},setup(){const e=h(!1);return y(()=>{let s=new Image;s.onload=()=>{e.value=!0},s.src="/storage/images/login-page-background.jpg"}),{imgReady:e}}}),N={class:"min-h-screen flex flex-col justify-center py-4 sm:px-6 lg:px-8 login-page-background-image"},F={key:0,class:"mt-6 sm:mx-auto bg-white sm:w-full sm:max-w-md shadow"},U=t("div",{class:"sm:mx-auto mt-8 sm:w-full sm:max-w-md"},[t("h2",{class:"mt-6 text-center text-3xl font-extrabold text-gray-900"}," Re\u0123istr\u0101cija ")],-1),A={class:"bg-white py-8 px-4 sm:rounded-lg sm:px-10"},I={class:"mt-4"},M={class:"mt-4"},P={class:"mt-4"},S={class:"mt-4"},z={class:"flex items-center justify-end mt-4"};function D(e,s,O,T,G,K){var l;const u=i("Head"),c=i("jet-validation-errors"),n=i("jet-label"),r=i("jet-input"),f=i("jet-button");return m(),d(C,null,[o(u,{title:"Re\u0123istr\u0101cija"}),t("div",N,[e.imgReady?(m(),d("div",F,[U,t("div",A,[o(c,{class:"mb-4"}),t("form",{class:"space-y-6",onSubmit:s[3]||(s[3]=V((...a)=>e.submit&&e.submit(...a),["prevent"]))},[t("div",null,[o(n,{for:"name",value:"V\u0101rds"}),o(r,{name:"name",id:"name",type:"text",class:"mt-1 block w-full",modelValue:e.form.name,"onUpdate:modelValue":s[0]||(s[0]=a=>e.form.name=a),required:"",autofocus:"",autocomplete:"name"},null,8,["modelValue"])]),t("div",I,[o(n,{for:"email",value:"E-pasts"}),o(r,{name:"email",class:"bg-gray-100 mt-1 block w-full",disabled:"",id:"email",type:"email","model-value":e.invitation.email,required:""},null,8,["model-value"])]),t("div",M,[o(n,{for:"roles",value:"Lomas"}),p(" "+j((l=e.invitation.roles)==null?void 0:l.map(a=>a.name).join(", ")),1)]),t("div",P,[o(n,{for:"password",value:"Parole"}),o(r,{name:"password",id:"password",type:"password",class:"mt-1 block w-full",modelValue:e.form.password,"onUpdate:modelValue":s[1]||(s[1]=a=>e.form.password=a),required:"",autocomplete:"new-password"},null,8,["modelValue"])]),t("div",S,[o(n,{for:"password_confirmation",value:"Parole atk\u0101rtoti"}),o(r,{name:"password_confirmation",id:"password_confirmation",type:"password",class:"mt-1 block w-full",modelValue:e.form.password_confirmation,"onUpdate:modelValue":s[2]||(s[2]=a=>e.form.password_confirmation=a),required:"",autocomplete:"new-password"},null,8,["modelValue"])]),t("div",z,[o(f,{class:J(["ml-4 register-button",{"opacity-25":e.form.processing}]),disabled:e.form.processing},{default:k(()=>[p(" Re\u0123istr\u0113ties ")]),_:1},8,["class","disabled"])])],32)])])):x("",!0)])],64)}const oe=_(H,[["render",D]]);export{oe as default};
