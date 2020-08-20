// 若需確認抽獎呈現正確，請註解洗牌的code
// 獎品資料處裡
let awardNumber = [];
const initialAwardNumber = () => {
  for (let i = 0; i < 10000; i++) {
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
// 開網頁時先洗一次
awardNumber = shuffle(awardNumber);

// spinner
let isLoading = false;

// 事件監聽+畫面呈現
const pickNumber = document.getElementById('start');

pickNumber.addEventListener('click', () => {
  isLoading = true;
  const spinnerDisplay = (isLoading) => {
    if (isLoading) {
      document.getElementById('award').innerHTML = `
      <div class="text-center" style="margin:120px 0;">
        <div class="spinner-border text-primary" role="status" style="width: 4rem; height: 4rem;">
          <span class="sr-only">Loading...</span>
        </div>
      </div>`;
    }
  };

  spinnerDisplay(isLoading);

  setTimeout(() => {
    //spinner end
    isLoading = false;

    // 畫面呈現
    let display = `<h3>獎品號碼：${awardNumber[0]}</h3>`;

    // 判斷獎項1-5狀態
    // 以號碼代表獎品：
    // 1是電視(1台)，2-4是ps4遊戲機(3台)，5-14是充電器(10台)，15-114是購物券(100張)
    let status = null;
    const statusCheck = (number) => {
      if (number == 1) {
        status = 1;
      }
      if (2 <= number && number <= 4) {
        status = 2;
      }
      if (5 <= number && number <= 14) {
        status = 3;
      }
      if (15 <= number && number <= 114) {
        status = 4;
      }
      if (115 <= number) {
        status = 5;
      }
    };
    statusCheck(awardNumber[0]);

    // 獎品圖挑選
    const pickImg = (status) => {
      let imgDisplay = '';
      switch (status) {
        case 1:
          imgDisplay = `<img src="./images/tv.jpg" alt="頭獎50吋電視">`;
          break;
        case 2:
          imgDisplay = `<img src="./images/ps4.png" alt="二等獎PS4">`;
          break;
        case 3:
          imgDisplay = `<img src="./images/battery.jpg" alt="三等獎行動電源">`;
          break;
        case 4:
          imgDisplay = `<img src="./images/7-11ticket.jpg" alt="四等獎7-11消費券">`;
          break;
        default:
          imgDisplay = `<img src="./images/sorry.jpg" alt="銘謝惠顧">`;
          break;
      }
      return imgDisplay;
    };
    let imgDisplay = pickImg(status);
    console.log(status);
    display += `<div class="box">${imgDisplay}<div>`;

    // member is full
    if (!awardNumber[0]) {
      display = `<h3>活動名額已滿</h3><div class="box">${imgDisplay}<div>`;
    }
    document.getElementById('award').innerHTML = display;

    // 移出已經選到的號碼(陣列第一個)，並洗牌
    awardNumber.shift();
    awardNumber = shuffle(awardNumber);
    console.log(awardNumber);
    console.log(awardNumber[0]);

    // 剩下名額
    let remainDisplay = `還剩下：${awardNumber.length}個抽獎名額`;
    document.getElementById('remainAward').innerHTML = remainDisplay;
  }, 1000);
});
