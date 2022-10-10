import{J as V}from"./ActionMessage.1ea530df.js";import{M,J as L,a as N}from"./DialogModal.af9a536b.js";import{J as x}from"./Button.c56bed8d.js";import{d as T,_ as j,r,o as l,c as U,w as o,a as s,e as g,f as d,b as i,g as a,F as f,h as _,t as p,i as c,n as h}from"./app.f1ef34bf.js";import{J as E}from"./DangerButton.9399c8b2.js";import{J as W}from"./FormSection.03435788.js";import{J as q}from"./Input.4240a7e1.js";import{J as G}from"./Checkbox.b7ebc84e.js";import{J as H}from"./InputError.baa9cf10.js";import{J as K}from"./Label.36e42c47.js";import{J as O}from"./SecondaryButton.665ae083.js";import{J as Q}from"./SectionBorder.df436864.js";const R=T({emits:["close"],components:{Modal:M},props:{show:{default:!1},maxWidth:{default:"2xl"},closeable:{default:!0}},methods:{close(){this.$emit("close")}}}),X={class:"bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4"},Y={class:"sm:flex sm:items-start"},Z=s("div",{class:"mx-auto shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10"},[s("svg",{class:"h-6 w-6 text-red-600",stroke:"currentColor",fill:"none",viewBox:"0 0 24 24"},[s("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"})])],-1),ee={class:"mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left"},oe={class:"text-lg"},te={class:"mt-2"},se={class:"flex flex-row justify-end px-6 py-4 bg-gray-100 text-right"};function ne(e,n,y,$,F,P){const u=r("modal");return l(),U(u,{show:e.show,"max-width":e.maxWidth,closeable:e.closeable,onClose:e.close},{default:o(()=>[s("div",X,[s("div",Y,[Z,s("div",ee,[s("h3",oe,[g(e.$slots,"title")]),s("div",te,[g(e.$slots,"content")])])])]),s("div",se,[g(e.$slots,"footer")])]),_:3},8,["show","max-width","closeable","onClose"])}const ie=j(R,[["render",ne]]),ae=T({components:{JetActionMessage:V,JetActionSection:L,JetButton:x,JetConfirmationModal:ie,JetDangerButton:E,JetDialogModal:N,JetFormSection:W,JetInput:q,JetCheckbox:G,JetInputError:H,JetLabel:K,JetSecondaryButton:O,JetSectionBorder:Q},props:["tokens","availablePermissions","defaultPermissions"],data(){return{createApiTokenForm:this.$inertia.form({name:"",permissions:this.defaultPermissions}),updateApiTokenForm:this.$inertia.form({permissions:[]}),deleteApiTokenForm:this.$inertia.form(),displayingToken:!1,managingPermissionsFor:null,apiTokenBeingDeleted:null}},methods:{createApiToken(){this.createApiTokenForm.post(route("api-tokens.store"),{preserveScroll:!0,onSuccess:()=>{this.displayingToken=!0,this.createApiTokenForm.reset()}})},manageApiTokenPermissions(e){this.updateApiTokenForm.permissions=e.abilities,this.managingPermissionsFor=e},updateApiToken(){this.updateApiTokenForm.put(route("api-tokens.update",this.managingPermissionsFor),{preserveScroll:!0,preserveState:!0,onSuccess:()=>this.managingPermissionsFor=null})},confirmApiTokenDeletion(e){this.apiTokenBeingDeleted=e},deleteApiToken(){this.deleteApiTokenForm.delete(route("api-tokens.destroy",this.apiTokenBeingDeleted),{preserveScroll:!0,preserveState:!0,onSuccess:()=>this.apiTokenBeingDeleted=null})}}}),re={class:"col-span-6 sm:col-span-4"},le={key:0,class:"col-span-6"},de={class:"mt-2 grid grid-cols-1 md:grid-cols-2 gap-4"},me={class:"flex items-center"},pe={class:"ml-2 text-sm text-gray-600"},ce={key:0},ue={class:"mt-10 sm:mt-0"},ke={class:"space-y-6"},ge={class:"flex items-center"},fe={key:0,class:"text-sm text-gray-400"},_e=["onClick"],he=["onClick"],ve=s("div",null," L\u016Bdzu dro\u0161i saglab\u0101 API tokenu. Dro\u0161\u012Bbas nol\u016Bkos, tas vairs neb\u016Bs redzams sist\u0113m\u0101. ",-1),be={key:0,class:"mt-4 bg-gray-100 px-4 py-2 rounded font-mono text-sm text-gray-500"},Ae={class:"grid grid-cols-1 md:grid-cols-2 gap-4"},Te={class:"flex items-center"},je={class:"ml-2 text-sm text-gray-600"};function ye(e,n,y,$,F,P){const u=r("jet-label"),J=r("jet-input"),C=r("jet-input-error"),v=r("jet-checkbox"),w=r("jet-action-message"),b=r("jet-button"),z=r("jet-form-section"),S=r("jet-section-border"),B=r("jet-action-section"),k=r("jet-secondary-button"),A=r("jet-dialog-modal"),I=r("jet-danger-button"),D=r("jet-confirmation-modal");return l(),d("div",null,[i(z,{onSubmitted:e.createApiToken},{title:o(()=>[a(" Izveidot API tokenu ")]),description:o(()=>[a(" API tokeni dod iesp\u0113ju citai sist\u0113mai integr\u0113ties ar \u0161o sist\u0113mu. ")]),form:o(()=>[s("div",re,[i(u,{for:"name",value:"Nosaukums"}),i(J,{id:"name",type:"text",class:"mt-1 block w-full",modelValue:e.createApiTokenForm.name,"onUpdate:modelValue":n[0]||(n[0]=t=>e.createApiTokenForm.name=t),autofocus:""},null,8,["modelValue"]),i(C,{message:e.createApiTokenForm.errors.name,class:"mt-2"},null,8,["message"])]),e.availablePermissions.length>0?(l(),d("div",le,[i(u,{for:"permissions",value:"At\u013Caujas"}),s("div",de,[(l(!0),d(f,null,_(e.availablePermissions,t=>(l(),d("div",{key:t},[s("label",me,[i(v,{value:t,checked:e.createApiTokenForm.permissions,"onUpdate:checked":n[1]||(n[1]=m=>e.createApiTokenForm.permissions=m)},null,8,["value","checked"]),s("span",pe,p(t),1)])]))),128))])])):c("",!0)]),actions:o(()=>[i(w,{on:e.createApiTokenForm.recentlySuccessful,class:"mr-3"},{default:o(()=>[a(" Izveidots. ")]),_:1},8,["on"]),i(b,{class:h({"opacity-25":e.createApiTokenForm.processing}),disabled:e.createApiTokenForm.processing},{default:o(()=>[a(" Izveidot ")]),_:1},8,["class","disabled"])]),_:1},8,["onSubmitted"]),e.tokens.length>0?(l(),d("div",ce,[i(S),s("div",ue,[i(B,null,{title:o(()=>[a(" P\u0101rvald\u012Bt API tokenus ")]),description:o(()=>[a(" J\u016Bs varat izdz\u0113st eso\u0161os tokenus, ja tie vairs nav nepiecie\u0161ami. ")]),content:o(()=>[s("div",ke,[(l(!0),d(f,null,_(e.tokens,t=>(l(),d("div",{class:"flex items-center justify-between",key:t.id},[s("div",null,p(t.name),1),s("div",ge,[t.last_used_ago?(l(),d("div",fe," P\u0113d\u0113jo reizi izmantots "+p(t.last_used_ago),1)):c("",!0),e.availablePermissions.length>0?(l(),d("button",{key:1,class:"cursor-pointer ml-6 text-sm text-gray-400 underline",onClick:m=>e.manageApiTokenPermissions(t)}," At\u013Caujas ",8,_e)):c("",!0),s("button",{class:"cursor-pointer ml-6 text-sm text-red-500",onClick:m=>e.confirmApiTokenDeletion(t)}," Izdz\u0113st ",8,he)])]))),128))])]),_:1})])])):c("",!0),i(A,{show:e.displayingToken,onClose:n[3]||(n[3]=t=>e.displayingToken=!1)},{title:o(()=>[a(" API tokens ")]),content:o(()=>[ve,e.$page.props.jetstream.flash.token?(l(),d("div",be,p(e.$page.props.jetstream.flash.token),1)):c("",!0)]),footer:o(()=>[i(k,{onClick:n[2]||(n[2]=t=>e.displayingToken=!1)},{default:o(()=>[a(" Aizv\u0113rt ")]),_:1})]),_:1},8,["show"]),i(A,{show:e.managingPermissionsFor,onClose:n[6]||(n[6]=t=>e.managingPermissionsFor=null)},{title:o(()=>[a(" API tokena at\u013Caujas ")]),content:o(()=>[s("div",Ae,[(l(!0),d(f,null,_(e.availablePermissions,t=>(l(),d("div",{key:t},[s("label",Te,[i(v,{value:t,checked:e.updateApiTokenForm.permissions,"onUpdate:checked":n[4]||(n[4]=m=>e.updateApiTokenForm.permissions=m)},null,8,["value","checked"]),s("span",je,p(t),1)])]))),128))])]),footer:o(()=>[i(k,{onClick:n[5]||(n[5]=t=>e.managingPermissionsFor=null)},{default:o(()=>[a(" Atcelt ")]),_:1}),i(b,{class:h(["ml-2",{"opacity-25":e.updateApiTokenForm.processing}]),onClick:e.updateApiToken,disabled:e.updateApiTokenForm.processing},{default:o(()=>[a(" Saglab\u0101t ")]),_:1},8,["onClick","class","disabled"])]),_:1},8,["show"]),i(D,{show:e.apiTokenBeingDeleted,onClose:n[8]||(n[8]=t=>e.apiTokenBeingDeleted=null)},{title:o(()=>[a(" Izdz\u0113st API tokenu ")]),content:o(()=>[a(" Vai esi dro\u0161s, ka v\u0113lies izdz\u0113st \u0161o API tokenu? ")]),footer:o(()=>[i(k,{onClick:n[7]||(n[7]=t=>e.apiTokenBeingDeleted=null)},{default:o(()=>[a(" Atcelt ")]),_:1}),i(I,{class:h(["ml-2",{"opacity-25":e.deleteApiTokenForm.processing}]),onClick:e.deleteApiToken,disabled:e.deleteApiTokenForm.processing},{default:o(()=>[a(" Izdz\u0113st ")]),_:1},8,["onClick","class","disabled"])]),_:1},8,["show"])])}const Me=j(ae,[["render",ye]]);export{Me as default};
