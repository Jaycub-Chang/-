// 獎品資料處裡
// 機率等同100張卡裡面佔幾張
let awardNumber = [];
const initialAwardNumber = () => {
  for (let i = 0; i < 100; i++) {
    awardNumber.push(i + 1);
  }
};
initialAwardNumber();

// 隨機洗牌
function shuffle(array) {
  let m = array.length,
    t,
    i;
  // While there remain elements to shuffle…
  while (m) {
    // Pick a remaining element…
    i = Math.floor(Math.random() * m--);

    // And swap it with the current element.
    t = array[m];
    array[m] = array[i];
    array[i] = t;
  }
  return array;
}

awardNumber = shuffle(awardNumber);

// spinner
let isLoading = false;

// 事件監聽+畫面呈現
const pickNumber = document.getElementById('start');
pickNumber.addEventListener('click', () => {
  isLoading = true;
  const displaySpinner = (isLoading) => {
    if (isLoading) {
      document.getElementById('award').innerHTML = `
        <div class="text-center" style="margin:120px 0;">
          <div class="spinner-border text-primary" role="status" style="width: 4rem; height: 4rem;">
            <span class="sr-only">Loading...</span>
          </div>
        </div>
      `;
    }
  };
  displaySpinner(isLoading);

  // 只洗牌，不移出(無限卡牌)。抽卡前先洗
  awardNumber = shuffle(awardNumber);
  console.log(awardNumber);

  // 畫面呈現
  let display = ``;
  setTimeout(() => {
    // close spinner
    isLoading = false;

    // 判斷獎項1-3狀態
    // 以號碼代表獎品：
    // 1-2是3星神卡，3-20是2星神卡，21以上是1星素材
    let status = null;
    const statusCheck = (number) => {
      if (number <= 2) {
        status = 1;
      }
      if (3 <= number && number <= 20) {
        status = 2;
      }
      if (21 <= number) {
        status = 3;
      }
    };
    statusCheck(awardNumber[0]);

    // 卡片圖+文字挑選
    const pickImg = (status) => {
      switch (status) {
        case 1:
          display = `<h2>天啊！是<span>三星</span>北歐神百合雙子(戀愛了)</h2><div class="box"><img src="./images/北歐神.jpg" alt="3星神"><div>`;
          break;
        case 2:
          display = `<h2>是<span>二星神</span>日本和神山海雙子兄弟丼(口水)</h2><div class="box"><img src="./images/山海神.jpg" alt="2星神"><div>`;
          break;
        default:
          display = `<h2><span>一星神</span>...昂貴肥料吧(但好可愛捨不得吃QQ)</h2><div class="box"><img src="./images/素材.jpg" alt="1星素材"><div>`;
          break;
      }
    };
    pickImg(status);
    console.log(status);
    document.getElementById('award').innerHTML = display;
  }, 1000);
});
