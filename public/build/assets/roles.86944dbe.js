import{C as h}from"./CrudTable.74672346.js";import{o as i,f as o,e as y,n as m,i as c,t as b,z as f,_ as g,c as v,w as C,b as x,r as u}from"./app.f1ef34bf.js";var d={name:"Chip",emits:["remove"],props:{label:{type:String,default:null},icon:{type:String,default:null},image:{type:String,default:null},removable:{type:Boolean,default:!1},removeIcon:{type:String,default:"pi pi-times-circle"}},data(){return{visible:!0}},methods:{close(l){this.visible=!1,this.$emit("remove",l)}},computed:{containerClass(){return["p-chip p-component",{"p-chip-image":this.image!=null}]},iconClass(){return["p-chip-icon",this.icon]},removeIconClass(){return["p-chip-remove-icon",this.removeIcon]}}};const _=["src"],k={key:2,class:"p-chip-text"};function S(l,t,e,n,s,a){return s.visible?(i(),o("div",{key:0,class:m(a.containerClass)},[y(l.$slots,"default",{},()=>[e.image?(i(),o("img",{key:0,src:e.image},null,8,_)):e.icon?(i(),o("span",{key:1,class:m(a.iconClass)},null,2)):c("",!0),e.label?(i(),o("div",k,b(e.label),1)):c("",!0)]),e.removable?(i(),o("span",{key:0,tabindex:"0",class:m(a.removeIconClass),onClick:t[0]||(t[0]=(...r)=>a.close&&a.close(...r)),onKeydown:t[1]||(t[1]=f((...r)=>a.close&&a.close(...r),["enter"]))},null,34)):c("",!0)],2)):c("",!0)}function N(l,t){t===void 0&&(t={});var e=t.insertAt;if(!(!l||typeof document>"u")){var n=document.head||document.getElementsByTagName("head")[0],s=document.createElement("style");s.type="text/css",e==="top"&&n.firstChild?n.insertBefore(s,n.firstChild):n.appendChild(s),s.styleSheet?s.styleSheet.cssText=l:s.appendChild(document.createTextNode(l))}}var D=`
.p-chip {
    display: -webkit-inline-box;
    display: -ms-inline-flexbox;
    display: inline-flex;
    -webkit-box-align: center;
        -ms-flex-align: center;
            align-items: center;
}
.p-chip-text {
    line-height: 1.5;
}
.p-chip-icon.pi {
    line-height: 1.5;
}
.p-chip-remove-icon {
    line-height: 1.5;
    cursor: pointer;
}
.p-chip img {
    border-radius: 50%;
}
`;N(D);d.render=S;const w={name:"index",components:{CrudTable:h,Chip:d},props:{roles:Array,listings:Object},setup(){return{columns:[{type:"text",name:"name",header:"Nosaukums",sortable:!0,searchable:!0,required:!0},{type:"multiselect",name:"permissions",label:"name",listing:"permissions",value:"id",header:"At\u013Caujas"}],labels:{createHeader:"Izveidot lomu",editHeader:"Atjaunot lomu"},routesName:{massDestroy:"roles.massDestroy",updateSingle:"roles.update",storeSingle:"roles.store",singleDestroy:"roles.destroy"}}}};function B(l,t,e,n,s,a){const r=u("crud-table"),p=u("app-layout");return i(),v(p,{title:"Dashboard"},{default:C(()=>[x(r,{tableData:e.roles,columns:n.columns,"crud-name":"role",title:"Lomas",labels:n.labels,"route-names":n.routesName,listings:e.listings,"per-page":50},null,8,["tableData","columns","labels","route-names","listings"])]),_:1})}const j=g(w,[["render",B]]);export{j as default};
