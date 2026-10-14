document.addEventListener('DOMContentLoaded',()=>{
 const form=document.querySelector('[data-movement-form]'); const select=document.querySelector('[data-stock-select]'); const qty=document.querySelector('[data-qty]'); const help=document.querySelector('[data-stock-help]');
 function update(){if(!select||!qty||!help)return;const opt=select.options[select.selectedIndex];const stock=Number(opt?.dataset.stock||0);help.textContent=`Stock disponible: ${stock} unidades`;if(form?.querySelector('[name="tipo"]')?.value==='salida'){qty.max=stock;qty.title=`Máximo disponible: ${stock}`;}else qty.removeAttribute('max');}
 select?.addEventListener('change',update); update();
 document.querySelectorAll('[data-confirm]').forEach(el=>el.addEventListener('click',e=>{if(!confirm(el.dataset.confirm))e.preventDefault();}));
 const invoiceType=document.querySelector('[data-invoice-type]'); const invoiceParty=document.querySelector('[data-invoice-party]');
 function updateInvoiceParty(){if(!invoiceType||!invoiceParty)return;invoiceParty.value='';invoiceParty.querySelectorAll('[data-party-type]').forEach(group=>{group.hidden=group.dataset.partyType!==invoiceType.value;});}
 invoiceType?.addEventListener('change',updateInvoiceParty); updateInvoiceParty();
});
