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


//建立路由
app.get('/', async (req, res, next) => {
    res.send();
});


//抓取檔案
let itemsData = [];
//設定搜尋關鍵字
const searchCategory = 'all-events';
let enterUrl = `https://www.musico.com.tw/${searchCategory}`;


let pageItemsLinks = []
let nextPageLink = null;
const headers = {
    'User-Agent': 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.80 Safari/537.36'
}

async function enterMenuPage() {
    await nightmare
        .goto(enterUrl, headers)
        .wait('div#event-list-section')
        .evaluate(() => {
            const targetDom = [];
            let menueDom = null;
            let pageDom = null;
            menueDom = document.querySelector('div#event-list-section').innerHTML;
            pageDom = (document.querySelector('div.pagination')) ? document.querySelector('div.pagination').innerHTML : `<div></div>`;
            targetDom.push(menueDom);
            targetDom.push(pageDom);
            return targetDom;
        })
        .then(async (data) => {
            // data = [menueDom,pageDom]
            await getThisPageItemsLinks(data[0]);
            await getNextPageLink(data[1]);
            await goToItemPage();
        })
        .catch(error => {
            console.log(`enterMenuPage失敗 - ${error}`);
        })
};


//取得產品連結
async function getThisPageItemsLinks(html) {
    let itemsLinkList = [];
    itemsLinkList = html.toString().split(`headline"><a href="`);

    let outputItemsLinks = [];
    for (let i = 1; i < itemsLinkList.length; i++) {
        let temp_itemLink = '';
        temp_itemLink = itemsLinkList[i].split(`">`);
        outputItemsLinks.push(temp_itemLink[0]);
    };

    // result: https://musico.com.tw/?post_type=events&amp;p=3434,  因出現 amp; 要去除
    for (let i = 0; i < outputItemsLinks.length; i++) {
        let str = outputItemsLinks[i].split(`amp;`).join('');
        pageItemsLinks.push(str);
    };
};


//取得之後頁面連結
async function getNextPageLink(html) {
    let $ = cheerio.load(html);
    let temp_nextPageLink = '';
    temp_nextPageLink = $('a.next.page-numbers').attr('href');
    nextPageLink = temp_nextPageLink;
    console.log(nextPageLink);
};


//進入專欄頁
async function goToItemPage() {
    for (let i = 0; i < pageItemsLinks.length; i++) {
        let itemLink = pageItemsLinks[i];
        await getItemData(itemLink);
    };

    await saveFileGoNextMenuPage();
};


//獲取所有單一產品資料
async function getItemData(link) {
    await nightmare
        .goto(link, headers)
        .wait('div.column_attr.clearfix.align_left')
        .evaluate(() => {
            let targetDom = null;
            targetDom = document.querySelector('div.content_wrapper.clearfix').outerHTML;
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
async function processData(html) {

    let temp_postData = {
        post_title: '',
        post_imgUrl: '',
        post_content: '',
        post_detail: {
            detail_title: [],
            detail_content: [],
        },
    };

    // post_title
    let $ = cheerio.load(html);
    temp_postData.post_title = $(`div.post-main-title`).text().trim();

    // post_imgUrl
    temp_postData.post_imgUrl = $(`img.scale-with-grid`).attr('src');

    // post_content
    temp_postData.post_content = $(`div.column_attr.clearfix.align_left`).text();

    // post_detail_title
    let detail_title_arr = html.toString().split(`each-title">`);
    for (let i = 1; i < detail_title_arr.length; i++) {
        let str = detail_title_arr[i].split(`</span`);
        temp_postData.post_detail.detail_title.push(str[0]);
    };

    // post_detail_content
    let detail_content_arr = html.toString().split(`each-content">`);
    for (let i = 1; i < detail_content_arr.length; i++) {
        let str = detail_content_arr[i].split(`</span`);
        temp_postData.post_detail.detail_content.push(str[0]);
    };

    itemsData.push(temp_postData);
};


//  存檔並前往下一頁
let pageNum = 1;
async function saveFileGoNextMenuPage() {

    //  fs.appendFile 分次儲存 json 格式不連接出現 "[][][]..." 的問題，結束後用尋找全部替換成 ","
    await fs.appendFile(__dirname + `/../data/${searchCategory}.json`, JSON.stringify(itemsData), function (err) {
        if (err) {
            console.log('存檔失敗');
            console.log(err);
        } else {
            console.log(`完成 ${searchCategory} 第 ${pageNum} 次存檔`);
            itemsData = [];

            // 先前是直接重新指定新陣列，這邊要重新指定
            pageItemsLinks = [];
            pageNum++;
        }
    });

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
//   enterMenuPage >> getThisPageItemsLinks >> getNextPageLink >> goToItemPage  >> processData >> saveFileGoNextMenuPage >> {enterMenuPage ... } >>  processJsonFile  >>  closeChannel


try {
    asyncArray([enterMenuPage, closeChannel]).then(async () => {
        console.log('完成所有程式');
    });
} catch (err) {
    console.log('try-catch: ');
    console.dir(err, { depth: null });
}


