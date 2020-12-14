const express = require('express');
const app = express();
const fs = require('fs');

//建立第三方套件
const cheerio = require('cheerio');
const Nightmare = require('nightmare');          // 自動化測試包，處理動態頁面
const nightmare = Nightmare({ show: true });     // show:true  顯示內建模擬瀏覽器


//server 監聽
let server = app.listen(3000, function () {
    let host = server.address().address;
    let port = server.address().port;
    console.log('Your App is running at http://%s:%s', host, port);
});

//引入json在網頁看
// const sm_earphone_noline_page1 = require(__dirname + '/../data/耳塞式耳機_真無線_第1頁.json');
// const mic_page1 = require(__dirname + '/../data/專業麥克風_有線麥克風/專業麥克風_有線麥克風_第1頁.json');
// const lg_earphone_withline_page1 = require(__dirname + '/../data/耳罩式耳機_有線/耳罩式耳機_有線_第1頁.json');
// const lg_earphone_noline_page1 = require(__dirname + '/../data/耳罩式耳機_無線/耳罩式耳機_無線_第1頁.json');

//建立路由
// app.get('/', async (req, res, next) => {
//     res.send(sm_earphone_noline_page1);
// });
// app.get('/mic', async (req, res, next) => {
//     res.send(mic_page1);
// });
// app.get('/lg_earphone_withline_page1', async (req, res, next) => {
//     res.send(lg_earphone_withline_page1);
// });
// app.get('/lg_earphone_noline_page1', async (req, res, next) => {
//     res.send(lg_earphone_noline_page1);
// });


//抓取檔案
let productsData = [];
//設定搜尋關鍵字
const searchCategory = '耳罩式耳機';
const searchKeyWord = '有線';
let enterUrl = `https://www.audio-technica.com.tw/${searchCategory}/${searchKeyWord}`;


let pageProductsLinks = []
let nextPageLink = null;
const headers = {
    'User-Agent': 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/537.36'
}

async function enterMenuPage() {
    await nightmare
        .goto(enterUrl, headers)
        .wait('div.grid-list')
        .evaluate(() => {
            const targetDom = [];
            let menueDom = null;
            let pageDom = null;
            menueDom = document.querySelector('div.grid-list').innerHTML;
            pageDom = (document.querySelector('div.ty-pagination')) ? document.querySelector('div.ty-pagination').innerHTML : `<div></div>`;
            targetDom.push(menueDom);
            targetDom.push(pageDom);
            return targetDom;
        })
        .then(async (data) => {
            // data = [menueDom,pageDom]
            await getThisPageProductsLinks(data[0]);
            await getPagesLinks(data[1]);
            await goToProductPage();
        })
        .catch(error => {
            console.log(`enterMenuPage失敗 - ${error}`);
        })
};


//取得產品連結
async function getThisPageProductsLinks(html) {
    let $ = cheerio.load(html);
    let productsListLink = [];
    productsListLink = $('div.ty-column3');

    let outputProductsLinks = [];
    for (let i = 0; i < productsListLink.length; i++) {
        let $ = cheerio.load(productsListLink[i]);
        let temp_productLink = '';
        temp_productLink = $('a.product-title').attr('href');
        outputProductsLinks.push(temp_productLink);
    };

    pageProductsLinks = outputProductsLinks;
};


//取得之後頁面連結
async function getPagesLinks(html) {
    let $ = cheerio.load(html);
    let temp_nextPageLink = '';
    temp_nextPageLink = $('a.ty-pagination__item.ty-pagination__btn.ty-pagination__right-arrow').attr('href');
    nextPageLink = temp_nextPageLink;
};


//進入產品頁
async function goToProductPage() {
    for (let i = 0; i < pageProductsLinks.length; i++) {
        let itemLink = pageProductsLinks[i];
        await getProductData(itemLink);
    };

    await saveFileGoNextMenuPage();

};



//獲取所有單一產品資料
async function getProductData(link) {
    await nightmare
        .goto(link, headers)
        .wait('div.ty-product-img.cm-preview-wrapper img')
        .evaluate(() => {
            const targetDom = [];

            let productImagesDom = null;
            let productInfoDom = null;

            // productDetail = [title,description,features,warning]
            let productDetail = [];

            productImagesDom = document.querySelector('div.ty-product-img.cm-preview-wrapper').outerHTML;
            productInfoDom = document.querySelector('div.ty-product-block__left').outerHTML;
            productDetail.push(document.querySelector('div.ty-tabs.cm-j-tabs.clearfix').outerHTML);
            productDetail.push(document.querySelector('div#content_description').outerHTML);
            productDetail.push(document.querySelector('div#content_features').outerHTML);
            productDetail.push(document.querySelector('div#content_product_tab_23').outerHTML);

            targetDom.push(productImagesDom);
            targetDom.push(productInfoDom);
            targetDom.push(productDetail);
            return targetDom;
        })
        .then(async (data) => {
            await processData(data);
            console.log('成功 getProductData ');
        })
        .catch(error => {
            console.log(`getProductData失敗 - ${error}`);
        })
};


//處裡資料並存至全域陣列
async function processData(htmlDomData) {
    // htmlDomData = [ productImagesDom, productInfoDom, [title, description, features, warning] ]

    let tempProductData = {
        product_imagesUrl: [],
        product_info: {
            product_code: '',
            product_title: '',
            product_summary: '',
            original_price: '',
            current_price: '',
        },
        product_Detail: {
            content_title: [],
            product_content: {
                description: [],
                features: {
                    label: [],
                    value: [],
                },
                warning: '',
            },
        }
    };


    // 圖片
    // cheerio拿不到全部圖片只好用切的
    let str_arr = htmlDomData[0].toString().split(`src=\"`);
    for (let i = 1; i < str_arr.length; i++) {
        let imgSrc = str_arr[i].split('\" alt=');
        tempProductData.product_imagesUrl.push(imgSrc[0]);
    };

    //簡介
    let $ = cheerio.load(htmlDomData[1]);
    tempProductData.product_info.product_code = $('div.ty-product-block-code').text();
    tempProductData.product_info.product_title = $('h1.ty-product-block-title').text();
    tempProductData.product_info.product_summary = $('p').text();
    if ($('span.ty-list-price.ty-nowrap').text()) {
        tempProductData.product_info.original_price = $('span.ty-list-price.ty-nowrap').text();
    };
    if ($('div.ty-product-block__price-actual span.ty-price-num').text()) {
        tempProductData.product_info.current_price = $('span.ty-list-price.ty-nowrap').text();
    };


    // 詳細標題
    let temp_title_arr = htmlDomData[2][0].toString().split('<a class="ty-tabs__a">');
    for (let i = 1; i < temp_title_arr.length; i++) {
        let str = temp_title_arr[i].split(`</a>`);
        tempProductData.product_Detail.content_title.push(str[0]);
    };

    // 詳細內文
    // description
    let temp_description_arr = htmlDomData[2][1].toString().split(`;">`);
    for (let i = 1; i < temp_description_arr.length; i++) {
        let str = temp_description_arr[i].split(`</span>`);
        tempProductData.product_Detail.product_content.description.push(str[0]);
    };


    // features
    let temp_features_labels = htmlDomData[2][2].toString().split(`label">`);
    for (let i = 1; i < temp_features_labels.length; i++) {
        let str = temp_features_labels[i].split(`</span>`);
        tempProductData.product_Detail.product_content.features.label.push(str[0]);
    };
    let temp_features_values = htmlDomData[2][2].toString().split(`value">`);
    for (let i = 1; i < temp_features_values.length; i++) {
        let str = temp_features_values[i].split(`</div>`);
        tempProductData.product_Detail.product_content.features.value.push(str[0]);
    };

    // warning
    $ = cheerio.load(htmlDomData[2][3]);
    tempProductData.product_Detail.product_content.warning = $('div').text();
    productsData.push(tempProductData);
};


//  存檔並前往下一頁
let pageNum = 1;
async function saveFileGoNextMenuPage() {
    await fs.writeFile(__dirname + `/../data/${searchCategory}_${searchKeyWord}_第${pageNum}頁.json`, JSON.stringify(productsData), function (err) {
        if (err) {
            console.log('存檔失敗');
            console.log(err);
        } else {
            console.log(`完成 ${searchCategory}_${searchKeyWord}_第${pageNum}頁 另存新檔`);
            productsData = [];
            pageNum++;
        }
    });


    console.log('完成一頁');

    if (nextPageLink) {
        enterUrl = nextPageLink;
        console.log('進入下一頁');
        await enterMenuPage();
    };
}



//  關閉瀏覽器
async function closeChannel() {
    await nightmare.end((err) => {
        if (err) throw err;
        console.log('Nightmare is close.');
    });
};



//  照順序執行各個函式
async function asyncArray(functionsList) {
    for (let func of functionsList) {
        await func();
    }
}




//   <<<<主程式區域>>>>
//   enterMenuPage >> getThisPageProductsLinks >> getPagesLinks >> goToProductPage  >> processData >> saveFileGoNextMenuPage >> {enterMenuPage ... } >> closeChannel


try {
    asyncArray([enterMenuPage, closeChannel]).then(async () => {
        console.log('完成所有程式');
    });
} catch (err) {
    console.log('try-catch: ');
    console.dir(err, { depth: null });
}



