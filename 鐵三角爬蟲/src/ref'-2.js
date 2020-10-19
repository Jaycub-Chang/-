const express = require('express');
const app = express();

//建立第三方套件
const superagent = require('superagent');
const cheerio = require('cheerio');
const Nightmare = require('nightmare');          // 自動化測試包，處理動態頁面
const nightmare = Nightmare({ show: true });     // show:true  顯示內建模擬瀏覽器

//引入json
const rawHomeData = require(__dirname + '/../data/google_home_page.json');
const rawChannelLinks = require(__dirname + '/../data/channelLinks');

//server 監聽
let server = app.listen(3000, function () {
    let host = server.address().address;
    let port = server.address().port;
    console.log('Your App is running at http://%s:%s', host, port);
});

//建立路由
app.get('/', async (req, res, next) => {
    res.send(homePagePodcasts);
});
app.get('/channel_data', async (req, res, next) => {
    res.send(channelLinks);
    console.log(channelLinks.length);
    // console.log(google_home_page);
});
app.get('/rss_data', async (req, res, next) => {
    res.send(channelRSSLinks);
    // console.log(google_home_page);
});


//抓取檔案
let homePagePodcasts = [];

// [description] - 使用superagent.get()方法來訪問
superagent.get('https://podcasts.google.com/?hl=zh-TW').end((err, res) => {
    if (err) {
        // 如果訪問失敗或者出錯，會這行這裡
        console.log(`抓取失敗 - ${err}`)
    } else {
        // 訪問成功，請求頁面所返回的資料會包含在res
        homePagePodcasts = getFamousPodcasts(res);
    }
});

//設定抓取網頁節點
const getFamousPodcasts = (res) => {
    let tempFamousPodcasts = [];

    // 訪問成功，請求頁面所返回的資料會包含在res.text中。
    /* 使用cheerio模組的cherrio.load()方法，將HTMLdocument作為引數傳入函式
    以後就可以使用類似jQuery的$(selectior)的方式來獲取頁面元素
    */
    let $ = cheerio.load(res.text);


    // 找到目標資料所在的頁面元素，獲取資料
    // cherrio中$('selector').each()用來遍歷所有匹配到的DOM元素
    // 引數idx是當前遍歷的元素的索引，ele就是當前便利的DOM元素
    $('scrolling-carousel').each((idx, ele) => {
        let listCategory = $(ele).siblings('div.ldf2Je').text();
        let listId = $(ele).attr('id');
        let data = {
            podcastCategory: listCategory,
            listId: listId,
            listData: [],
        };

        tempFamousPodcasts.push(data);
    });


    //each內似乎不能再用each跑回圈，因此拉出來寫
    tempFamousPodcasts.forEach((item) => {
        let id = item.listId;

        $(`scrolling-carousel#${id} a.c9x52d`).each((idx, ele) => {
            let onePodcastData = {
                title: $(ele).children('.aXmMSe').children('.eWeGpe').text(),
                channel_href: $(ele).attr('href'),
                channel_img: $(ele).children('.b7JYQ').children('img').attr('src'),
                channel_host: $(ele).children('.aXmMSe').children('.yFWEIe').text(),
            };
            item.listData.push(onePodcastData);
        });

    });

    return tempFamousPodcasts;

};


let channelLinks = [];
let channelRSSLinks = [];


rawHomeData.forEach((listCategory) => {
    listCategory.listData.forEach((channel) => {
        let str = {
            title: channel.title,
            link: channel.channel_href,
        };
        channelLinks.push(str);
    });
});


async function enterChannel() {

    for (let i = 0; i < rawChannelLinks.length; i++) {
        let tempLink = rawChannelLinks[i].link.split('.');
        // console.log(tempLink[1]);
        await getRSSLink(tempLink[1]);
    };

};


async function getRSSLink(link) {
    await nightmare
        .goto(`https://podcasts.google.com${link}`)
        .wait(`div.AZqljb.JSLBqe`)
        .evaluate(() => document.querySelector('div.S1V7Ud').nextSibling.getAttribute('jsdata'))
        .then(data => {
            let processData = data.split(';')
            console.log(processData[3]);
            console.log('進入頻道');
            channelRSSLinks.push(processData[3]);
        })
        .catch(error => {
            console.log(`本地新聞抓取失敗 - ${error}`);
        });
};

//關閉瀏覽器
async function closeChannel() {
    await nightmare.end((err) => {
        if (err) throw err;
        console.log('Nightmare is close.');
    });
};

//照順序執行各個函式
async function asyncArray(functionsList) {
    for (let func of functionsList) {
        await func();
    }
}


//主程式區域
try {
    asyncArray([enterChannel, closeChannel]).then(async () => {
        console.log(channelRSSLinks);
    });
} catch (err) {
    console.log('try-catch: ');
    console.dir(err, { depth: null });
}



