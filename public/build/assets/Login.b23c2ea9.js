import{_ as g,H as _,L as y,V as h,s as w,k,o as a,f as n,b as c,a as e,t as v,i,p as V,j as l,u,q as j,n as B,F as C,r as p}from"./app.f1ef34bf.js";const E={components:{Head:_,Link:y,JetValidationErrors:h},props:{canResetPassword:Boolean,status:String,app:{type:Object,default:{name:""}}},data(){return{form:this.$inertia.form({email:"",password:"",remember:!0})}},methods:{submit(){this.form.transform(r=>({...r,remember:this.form.remember?"on":""})).post("/login",{onSuccess:()=>{location.reload()},onFinish:()=>{this.form.reset("password")}})}},setup(){const r=w(!1);return k(()=>{let s=new Image;s.onload=()=>{r.value=!0},s.src="/storage/images/login-page-background.jpg",setTimeout(()=>r.value=!0,2e3)}),{imgReady:r}}},H={class:"min-h-screen flex flex-col justify-center py-4 px-2 sm:px-6 lg:px-8 login-page-background-image"},I={key:0,class:"mt-6 sm:mx-auto bg-white sm:w-full sm:max-w-md rounded-md shadow"},L=e("div",{class:"sm:mx-auto mt-8 sm:w-full sm:max-w-md"},[e("h2",{class:"mt-6 text-center text-3xl font-extrabold text-gray-900"}," Ien\u0101kt ")],-1),M={class:"bg-white py-8 px-4 sm:rounded-lg sm:px-10"},R={key:0,class:"mb-4 font-medium text-sm text-green-600"},S=e("label",{for:"email",class:"block text-sm font-medium text-gray-700"}," E-pasta adrese ",-1),q={class:"mt-1"},F=e("label",{for:"password",class:"block text-sm font-medium text-gray-700"}," Parole ",-1),N={class:"mt-1"},P={class:"flex items-center justify-between"},U={class:"flex items-center"},z=e("label",{for:"remember-me",class:"ml-2 block text-sm text-gray-900"}," Atcer\u0113ties mani ",-1),A={class:"text-sm"},D={key:0,href:"/forgot-password",class:"font-medium text-sky-600 hover:text-sky-500"},T=["disabled"];function J(r,s,m,f,t,d){const b=p("Head"),x=p("jet-validation-errors");return a(),n(C,null,[c(b,{title:"Ien\u0101kt"}),e("div",H,[f.imgReady?(a(),n("div",I,[L,e("div",M,[c(x,{class:"mb-4"}),m.status?(a(),n("div",R,v(m.status),1)):i("",!0),e("form",{class:"space-y-6",onSubmit:s[3]||(s[3]=V((...o)=>d.submit&&d.submit(...o),["prevent"]))},[e("div",null,[S,e("div",q,[l(e("input",{id:"email",name:"email",type:"email",autocomplete:"email","onUpdate:modelValue":s[0]||(s[0]=o=>t.form.email=o),required:"",class:"appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-0 focus:border-sky-500 sm:text-sm"},null,512),[[u,t.form.email]])])]),e("div",null,[F,e("div",N,[l(e("input",{id:"password",name:"password","onUpdate:modelValue":s[1]||(s[1]=o=>t.form.password=o),type:"password",autocomplete:"current-password",required:"",class:"appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-0 focus:border-sky-500 sm:text-sm"},null,512),[[u,t.form.password]])])]),e("div",P,[e("div",U,[l(e("input",{id:"remember-me",name:"remember-me",type:"checkbox","onUpdate:modelValue":s[2]||(s[2]=o=>t.form.remember=o),class:"h-4 w-4 text-sky-600 focus:ring-0 border-gray-300 rounded"},null,512),[[j,t.form.remember]]),z]),e("div",A,[m.canResetPassword?(a(),n("a",D," Aizmirsi paroli? ")):i("",!0)])]),e("div",null,[e("button",{type:"submit",class:B([{"opacity-25":t.form.processing},"w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-0"]),disabled:t.form.processing}," Ien\u0101kt ",10,T)])],32)])])):i("",!0)])],64)}const G=g(E,[["render",J]]);export{G as default};
