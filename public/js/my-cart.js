class LocalStorage{
    constructor() {
        this.storage="aroma_cart";
        this.cart_items=[];
        this.getStorageContent();

    }

    showModalMessage(message, css_class){
        let modal=document.getElementsByClassName('toast_container')[0];
        let span=modal.querySelector('span');
        span.textContent=message;
        modal.classList.add(css_class);
        modal.classList.remove('d-none');
        setTimeout(()=>{
            span.textContent="";
            modal.classList.remove(css_class);
            modal.classList.add('d-none');
        }, 3000);
    }

    clearStorage(){
        localStorage.removeItem(this.storage);
    }

    getStorageContent(){
        let content=JSON.parse(localStorage.getItem(this.storage));
        if(content){
            this.cart_items=content;
        }

    }

    setStorageContent(){
        localStorage.setItem(this.storage, JSON.stringify(this.cart_items));
    }

    collectData(tag, qty=1) {
        let product={};
        product.id = tag.getAttribute('data-id');
        product.name = tag.getAttribute('data-name');
        product.slug = tag.getAttribute('data-slug');
        product.acc_code = tag.getAttribute('data-acc_code');
        product.stock = parseInt(tag.getAttribute('data-stock'));
        product.regular_price = parseInt(tag.getAttribute('data-regular_price'));
        product.action_price = parseInt(tag.getAttribute('data-action_price'));
        product.selling_price=product.action_price > 0 ? product.action_price : product.regular_price;
        product.image = tag.getAttribute('data-image');
        product.qty=parseInt(qty);
        product.subtotal=product.qty*product.selling_price;
        //if this product is already in cart, show message that product is already in cart
        let product_is_in_cart=false;
        //console.log(this.cart_items)
        if(this.cart_items.length){
            this.cart_items.forEach((cart_item)=>{
                if(product.id==cart_item.id){
                    this.showModalMessage('This item is already in the cart', 'bg-danger');
                    product_is_in_cart=true;
                }
            });
        }
        if(!product_is_in_cart){
            this.cart_items.push(product);
            this.setStorageContent();
            this.showModalMessage('Item added to the cart', 'bg-success');

        }

    }

}

class showCartQuantity extends LocalStorage{
    constructor() {
        super();
        this.showCartQuantityInNav();
    }
    showCartQuantityInNav(){
        this.getStorageContent();
        let items=0;
        this.cart_items.forEach((item)=>{
            items +=item.qty;
        });

        document.getElementsByClassName('nav-shop__custom-circle')[0].textContent=items;
    }
}

class AddToCartFromCategoryPage extends LocalStorage{
    constructor(){
        super();

        this.giveListeners();

    }
    giveListeners(){
        let add_to_carts=document.getElementsByClassName('add_to_cart');
        for(let i=0; i<add_to_carts.length; i++){
            add_to_carts[i].addEventListener('click', (e)=>{
                this.collectData(e.target.closest('ul'));
            })
        }
    }
}

class AddToCartFromShowProductPage extends LocalStorage{
    constructor(){
        super();
        this.qty_error=document.getElementById('qty_error');

        this.qty=document.getElementById('qty');
        this.max_qty=document.getElementById('add_to_cart').getAttribute('data-stock');
        this.giveListeners();

    }
    giveListeners(){
       let btn_minus=document.getElementById('btn_minus');
       let btn_plus=document.getElementById('btn_plus');
       let add_to_cart=document.getElementById('add_to_cart');
       btn_minus.addEventListener('click', (e)=>{
           this.hideQtyError();
           if(this.qty.value>1){
               this.qty.value = parseInt(this.qty.value)-1;
           }
       });

       btn_plus.addEventListener('click', (e)=>{
           this.hideQtyError();
           if(this.qty.value<this.max_qty){
               this.qty.value = parseInt(this.qty.value)+1;
           }else{
               this.showQtyError();
           }
        });

        add_to_cart.addEventListener('click', (e)=>{
            this.collectData(e.target, this.qty.value);

        });

    }

    hideQtyError(){
       this.qty_error.classList.add('d-none');
    }
    showQtyError(){
        this.qty_error.classList.remove('d-none');
    }
}

class Cart extends LocalStorage{
    constructor(){
        super();
        this.subtotal=0;
        this.shipping_fee=0;
        this.total=0;
        this.showCartContent();
        this.giveListeners();

    }


    showCartContent(){
        this.getStorageContent();
        //if we have items, we show them and hide "no items in cart" message
        if(this.cart_items.length) {
            document.getElementById('no_items').classList.add('d-none');
            document.getElementsByClassName('table')[0].classList.remove('d-none');
            console.log('ima')

            let cart_items_table = document.getElementById('cart_items');
            console.log(this.cart_items);
            let rows = this.cart_items.map((item) => {
                return `
                <tr class="cart_item" data-id="${item.id}">
                    <td>
                        <button class="btn btn-outline-danger remove">X</button>
                    </td>
                    <td>
                        <div class="media ">
                            <div class="d-flex d-phone-none">
                                <img width="80px" src="/${item.image}" alt="product_image">
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="media ">
                            <div class="media-body">
                                <a href="/show-product/${item.slug}">${item.name}</a>
                            </div>
                        </div>
                    </td>
                    <td>
                        <h5 class="price">${this.formatPrice(item.selling_price)}</h5>
                    </td>
                    <td class="qty_col">
                        <p class="qty_error text-danger d-none">You can't order more quantities</p>
                        <div class="d-flex align-items-center  md-column ">
                            <button class="btn-outline-blue mr-1 btn_minus" type="button" ><i class="fas fa-minus"></i></button>
                            <input disabled type="number" name="qty" value="${item.qty}" class="quantity mr-1" min="1" max="">
                            <button class="btn-outline-blue mr-3 btn_plus" type="button"><i class="fas fa-plus"></i></button>
                        </div>
                    </td>
                    <td>
                        <h5 class="single_total">${this.formatPrice(item.subtotal)}</h5>
                    </td>
                </tr>
            `;
            });
            cart_items_table.innerHTML = rows.join('');
            this.calculateAndShowCartTotals();
        }

    }

    giveListeners(){
        //cart page
        let table=document.getElementById('cart_items');
        let pluses;
        let minuses;
        let removes;

        if(table){
            pluses=table.getElementsByClassName('btn_plus');
            minuses=table.getElementsByClassName('btn_minus');
            removes=table.getElementsByClassName('remove');

            if(pluses){
                for(let i=0; i<pluses.length; i++){
                    pluses[i].addEventListener('click', (e)=>{
                        this.increaseQty(e);
                    })
                }
            }
            if(minuses){
                for(let i=0; i<minuses.length; i++){
                    minuses[i].addEventListener('click', (e)=>{
                        this.decreaseQty(e);
                    })
                }
            }
            if(removes){
                for(let i=0; i<removes.length; i++){
                    removes[i].addEventListener('click', (e)=>{
                        this.removeFromCart(e);
                    })
                }
            }
        }





    }

    removeFromCart(e){
        let tr=e.target.closest('tr');
        let id=tr.getAttribute('data-id');
        this.cart_items.forEach((cart_item, index)=>{
            if(id==cart_item.id){
                this.cart_items.splice(index, 1);
                this.setStorageContent();
                this.showModalMessage('Item removed from the cart', 'bg-success');
                tr.classList.add('bg-danger');
                setTimeout(()=>{
                    tr.remove();
                },800);
            }
        });
    }

    changeTotalPerItem(tr, qty, price){
        let total_placeholder=tr.getElementsByClassName('single_total')[0];
        console.log(total_placeholder, price, qty)
        total_placeholder.textContent=this.formatPrice(parseInt(price)*parseInt(qty));
    }

    calculateAndShowCartTotals(){
        let subtotal=0;
        this.cart_items.forEach((item)=>{
            subtotal +=item.subtotal;
        });
        this.subtotal=subtotal;
        this.total=this.shipping_fee+this.subtotal;

        document.getElementById('subtotal').textContent=this.formatPrice(this.subtotal);
        document.getElementById('shipping_fee').textContent=this.formatPrice(this.shipping_fee);
        document.getElementById('total').textContent=this.formatPrice(this.total);
        //total_placeholder.textContent=this.formatPrice(this.subtotal);
    }

    formatPrice(num) {
        let p = (num/100).toFixed(2).split(".");
        return p[0].split("").reverse().reduce(function(acc, num, i, orig) {
            return num + (num != "-" && i && !(i % 3) ? "." : "") + acc;
        }, "") + "," + p[1];
    }

    decreaseQty(e){
        let tr=e.target.closest('tr');
        let input=tr.getElementsByTagName('input')[0];
        let id=tr.getAttribute('data-id');

        if(input.value>0){
            let new_qty=parseInt(input.value)-1;
            input.value = new_qty;
            this.cart_items.forEach((cart_item)=>{
                if(id==cart_item.id){
                    cart_item.qty=new_qty;
                    cart_item.subtotal=parseInt(new_qty) * parseInt(cart_item.selling_price);
                    this.changeTotalPerItem(tr, new_qty, cart_item.selling_price)
                    this.calculateAndShowCartTotals();
                    this.setStorageContent();
                }
            });
        }
    }

    increaseQty(e){
        let tr=e.target.closest('tr');
        let input=tr.getElementsByTagName('input')[0];
        let id=tr.getAttribute('data-id');
        this.cart_items.forEach((cart_item)=>{
            if(id==cart_item.id){
                let max_qty=cart_item.stock;
                if(input.value<max_qty){
                    let new_qty=parseInt(input.value)+1;
                    input.value = new_qty;
                    cart_item.qty=new_qty;
                    cart_item.subtotal=new_qty * parseInt(cart_item.selling_price);
                    this.changeTotalPerItem(tr, new_qty, cart_item.selling_price);
                    this.calculateAndShowCartTotals();
                    this.setStorageContent();
                }else{
                    //show for 2 sconds that user can't order more quantity
                    let td=e.target.closest('td');
                    let msg=td.getElementsByClassName('qty_error')[0];
                    let input=td.getElementsByTagName('input')[0];
                    msg.classList.remove('d-none');
                    input.classList.remove('quantity');
                    input.classList.add('quantity_error');
                    setTimeout(function(){
                        msg.classList.add('d-none');
                        input.classList.add('quantity');
                        input.classList.remove('quantity_error');
                    }, 2000);
                }

            }
        });

    }



}
