// data
const data = [
  {
    id: 109081601,
    name: 'Jaycub',
    occupation: '碎刃師',
    power: '7',
    intelligence: '9',
    agile: '8',
    skill: '星爆氣流斬',
  },
  {
    id: 109081602,
    name: 'Saber',
    occupation: '劍聖英靈',
    power: '10',
    intelligence: '5',
    agile: '6',
    skill: '誓約勝利之劍(Excalibur！)',
  },
  {
    id: 109081603,
    name: '善逸',
    occupation: '劍士',
    power: '6',
    intelligence: '7',
    agile: '9',
    skill: '雷之呼吸',
  },
];

let displayMember = '';
const createMemberHtml = (data) => {
  data.forEach((item) => {
    displayMember += `<tr>
      <th scope="row">${item.id}</th>
      <td>${item.name}</td>
      <td>${item.occupation}</td>
      <td>${item.power}</td>
      <td>${item.intelligence}</td>
      <td>${item.agile}</td>
      <td>${item.skill}</td>
    </tr>`;
  });
};

// implement function with data
createMemberHtml(data);

document.getElementById('memberInfo').innerHTML = displayMember;
