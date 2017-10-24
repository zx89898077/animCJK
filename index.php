<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="initial-scale=1.0,user-scalable=yes">
<style>
<?php $fs=256; ?>
body {font-size:1em;font-family:"arial",sans-serif;background:#eee;}
h1,div.link,div.input,#a,footer {text-align:center;}
div.link a, div.navigation a {color:#000;}
div.input, div.navigation {padding-top:1em;}
div.navigation a {display:inline-block;padding:0.25em;}
#data
{
	/* if one specifies "arial", characters are centered vertically, otherwise they may be not */
	display:block;
	font-family:"arial",sans-serif;
	text-align:center;
	width:8em;
	font-size:2em;
	height:1.5em;
	line-height:1.25em;
	margin:0 auto;
	padding:0;
	vertical-align:middle;
}
#ok
{	
	margin-top:0.5em;
	font-size:2em;
	-webkit-appearance:button;
}
#a
{
	width:<?php echo $fs;?>px;
	height:<?php echo $fs;?>px;
	margin:1em auto;
}
#a {border:1px solid #ccc;background:#fff;color:#000;}
#ok:hover,
#joyoSection button:hover,
#frequentSection button:hover {cursor:pointer;}
label {display:inline-block;white-space:nowrap;margin:0 0.5em 1em 0.5em;}
svg
{
	width:<?php echo $fs;?>px;
	height:<?php echo $fs;?>px;
}
svg.error {font-size:<?php echo $fs;?>px;}
#b
{
	width:<?php echo $fs;?>px;
	min-height:9.5em;
	margin:1em auto;
}
div.dico {margin:0 0.25em;padding-top:0.25em;text-align:left;line-height:1.25em;}
span.cjkChar {vertical-align:top;}

#joyoSection {display:block;}
#frequentSection {display:none;}
#joyoSection button, #frequentSection button
{
	border:1px solid #ccc;
	background:#fff;
	color:#000;
	font-size:1.25em;
	margin:0.1em;
}
#joyoSection button.sameInBoth,
#frequentSection button.sameInBoth
{color:#000;}
span.sameInBoth
{
	display:inline-block;
	width:3em;
	color:transparent;
	background:#000;
}
#joyoSection button.notSameInBoth,
#frequentSection button.notSameInBoth
{color:#00f;}
span.notSameInBoth
{
	display:inline-block;
	width:3em;
	color:transparent;
	background:#00f;
}
#joyoSection button.notInBoth,
#frequentSection button.notInBoth
{color:#090;}
span.notInBoth
{
	display:inline-block;
	width:3em;
	color:transparent;
	background:#090;
}
footer {padding-top:1em;}
footer a {color:#000;}
</style>
<title>AnimCJK Demo</title>
<script>
function setNumber(x)
{
	var go,g,list,k,km,l,a,c,e,cx,cy,cx1,cy1,cx2,cy2,d,sx,sy,fs=40,delay1,delay2;
	if (x)
	{
		list=document.querySelectorAll("svg.acjk path[clip-path]");
		km=list.length;
		l=0;
		go=0;
		for (k=0;k<km;k++)
		{
			if (k)
			{
				delay1=window.getComputedStyle(list[k]).getPropertyValue('animation-delay');
				delay2=window.getComputedStyle(list[k-1]).getPropertyValue('animation-delay');
			}
			if (!k||(delay1!=delay2))
			{
				// since several character svg can be in the page, do not set g outside the loop
				g=list[k];
				while (g.parentNode.tagName=="g") g=g.parentNode;
				if (g!=go) {l=1;go=g;} else l++;
				a=list[k].getAttribute("d");
				a=a.replace(/([0-9])[-]/g,"$1 -");
				c=a.match(/M[ ]*([0-9.-]+)[ ,]+([0-9.-]+)[^0-9.-]+([0-9.-]+)[ ,]+([0-9.-]+)/);
				if (c&&c.length)
				{
					cx1=parseInt(c[1]);
					cy1=parseInt(c[2]);
					cx2=parseInt(c[3]);
					cy2=parseInt(c[4]);
					d=Math.sqrt((cy2-cy1)*(cy2-cy1)+(cx2-cx1)*(cx2-cx1));
					if (d)
					{
						cx=cx1+(cx2-cx1)*fs/d/2;
						cy=cy1+(cy2-cy1)*fs/d/2;
					}
					else
					{
						cx=cx1;
						cy=cy1;
					}
					if (cx<(fs+(fs>>3))) cx=fs+(fs>>3);
					if (cy>(900-fs-(fs>>3))) cy=900-fs-(fs>>3);
					sx=((k+1)>=10)?0.875:1;
					sy=-1;
					e=document.createElementNS('http://www.w3.org/2000/svg','circle');;
					e.setAttribute("cx",cx);
					e.setAttribute("cy",cy);
					e.setAttribute("r",fs);
					e.setAttribute("stroke","#000");
					e.setAttribute("fill","#fff");
					e.setAttribute("stroke-width",Math.max(1,fs>>3));
					g.appendChild(e);
					e=document.createElementNS('http://www.w3.org/2000/svg','text');;
					e.setAttribute("x",cx);
					e.setAttribute("y",cy+(fs>>1));
					e.setAttribute("text-anchor","middle");
					e.setAttribute("font-family","arial");
					e.setAttribute("font-weight","normal");
					e.setAttribute("fill","#000");
					e.setAttribute("font-size",(fs>>1)*3);
					e.setAttribute("transform","matrix("+sx+",0,0,"+sy+","+(cx-sx*cx)+","+(cy-sy*cy)+")");
					e.textContent=l;
					g.appendChild(e);
				}
			}
		}
	}
	else
	{
		list=document.querySelectorAll("svg.acjk>g>circle, svg.acjk>g>text");
		km=list.length;
		if (km) 
			for (k=0;k<km;k++)
			{
				g=list[k].parentNode; // must set g here
				g.removeChild(list[k]);
			}
	}
}
function setSection()
{
	var list,k,km;
	list=document.getElementsByClassName("joyoSection");
	km=list.length;
	for (k=0;k<km;k++)
	{
		if (document.getElementById("joyoRadio").checked) list[k].style.display="block";
		else list[k].style.display="none";
	}
	list=document.getElementsByClassName("frequentSection");
	km=list.length;
	for (k=0;k<km;k++)
	{
		if (document.getElementById("frequentRadio").checked) list[k].style.display="block";
		else list[k].style.display="none";
	}
	document.getElementById("data").lang=(document.getElementById("joyoRadio").checked?"ja":"zh-Hans");
}
function switchNumber()
{
	setNumber(document.getElementById("number").checked);
}
function switchSection()
{
	ok();
}
function hideSvg()
{
	var list,k,km;
	list=document.querySelectorAll("#a svg");
	km=list.length;
	for (k=0;k<km;k++) list[k].style.visible="none";
}
function ok()
{
	var data,xhr,xhr2,lang,top,height;
	top=document.getElementById('a').offsetTop;
	height=document.getElementById('a').getBoundingClientRect().height;
	hideSvg();
	if (window.innerHeight>(top+height)) window.scrollTo(0,0);
    else window.scrollTo(0,top); 
	data=document.getElementById("data").value.replace(/\s/g,"");
	if (document.getElementById("joyoRadio").checked)
	{
		lang="ja";
		document.getElementById("joyoSection").style.display="block";
		document.getElementById("frequentSection").style.display="none";
	}
	else if (document.getElementById("frequentRadio").checked)
	{
		lang="zh-Hans";
		document.getElementById("joyoSection").style.display="none";
		document.getElementById("frequentSection").style.display="block";
	}
	else {alert("error!");return;}
	xhr=new XMLHttpRequest();
	xhr.onreadystatechange=function()
	{
		if ((xhr.readyState==4)&&(xhr.status==200))
		{
			document.getElementById("a").innerHTML=xhr.responseText;
			setNumber(document.getElementById("number").checked);
			setSection();
        }
    };
    xhr.open("POST","getOneFromSvgs.php",true);
	xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	xhr.send("data="+encodeURIComponent(data)+"&lang="+lang);
	xhr2=new XMLHttpRequest();
	xhr2.onreadystatechange=function()
	{
		if ((xhr2.readyState==4)&&(xhr2.status==200))
		{
			document.getElementById("b").innerHTML=xhr2.responseText;
        }
    };
    xhr2.open("POST","getOneFromDico.php",true);
	xhr2.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	xhr2.send("data="+encodeURIComponent(data)+"&lang="+lang);
}
function doIt(c)
{
	document.getElementById("data").value=c;
	ok();
}
</script>
</head>
<body>
<h1 id="top">AnimCJK Demo</h1>
<div class="link"><a href="https://github.com/parsimonhi/animCJK">Download</a></div>
<div class="input">
<div class="sectionSwitch">
<label>Japanese (Jōyō kanji): <input id="joyoRadio" type="radio" checked name="sectionSwitch" onclick="switchSection()"></label>
<label>Chinese (Frequently used hanzi): <input id="frequentRadio" type="radio" name="sectionSwitch" onclick="switchSection()"></label>
</div>
<div class="sectionCheckBox">
<label for="number">Stroke numbering: <input id="number" type="checkbox" onclick="switchNumber()"></label>
</div>
<input id="data" type="text" maxlength="1" value="" placeholder="Enter data here">
<input id="ok" type="button" value="Refresh" onclick="ok()">
</div>
<div id="a"></div>
<div id="b"></div>
<?php
function getCharList($set)
{
	if ($set=="g1")
	{
		$a="一七三上下中九二五人";
		$a.="休先入八六円出力十千";
		$a.="口右名四土夕大天女子";
		$a.="字学小山川左年手文日";
		$a.="早月木本村林校森正気";
		$a.="水火犬玉王生田男町白";
		$a.="百目石空立竹糸耳花草";
		$a.="虫見貝赤足車金雨青音";
	}
	else if ($set=="g2")
	{
		$a="万丸交京今会体何作元";
		$a.="兄光公内冬刀分切前北";
		$a.="午半南原友古台合同回";
		$a.="図国園地場声売夏外多";
		$a.="夜太妹姉室家寺少岩工";
		$a.="市帰広店弓引弟弱強当";
		$a.="形後心思戸才教数新方";
		$a.="明星春昼時晴曜書朝来";
		$a.="東楽歌止歩母毎毛池汽";
		$a.="活海点父牛理用画番直";
		$a.="矢知社秋科答算米紙細";
		$a.="組絵線羽考聞肉自船色";
		$a.="茶行西親角言計記話語";
		$a.="読谷買走近通週道遠里";
		$a.="野長門間雪雲電頭顔風";
		$a.="食首馬高魚鳥鳴麦黄黒";
	}
	else if ($set=="g3")
	{
		$a="丁世両主乗予事仕他代";
		$a.="住使係倍全具写列助勉";
		$a.="動勝化区医去反取受号";
		$a.="向君味命和品員商問坂";
		$a.="夫始委守安定実客宮宿";
		$a.="寒対局屋岸島州帳平幸";
		$a.="度庫庭式役待急息悪悲";
		$a.="想意感所打投拾持指放";
		$a.="整旅族昔昭暑暗曲有服";
		$a.="期板柱根植業様横橋次";
		$a.="歯死氷決油波注泳洋流";
		$a.="消深温港湖湯漢炭物球";
		$a.="由申界畑病発登皮皿相";
		$a.="県真着短研礼神祭福秒";
		$a.="究章童笛第筆等箱級終";
		$a.="緑練羊美習者育苦荷落";
		$a.="葉薬血表詩調談豆負起";
		$a.="路身転軽農返追送速進";
		$a.="遊運部都配酒重鉄銀開";
		$a.="院陽階集面題飲館駅鼻";
	}
	else if ($set=="g4")
	{
		$a="不争付令以仲伝位低例";
		$a.="便信倉候借停健側働億";
		$a.="兆児共兵典冷初別利刷";
		$a.="副功加努労勇包卒協単";
		$a.="博印参史司各告周唱喜";
		$a.="器囲固型堂塩士変央失";
		$a.="好季孫完官害察巣差希";
		$a.="席帯底府康建径徒得必";
		$a.="念愛成戦折挙改救敗散";
		$a.="料旗昨景最望未末札材";
		$a.="束松果栄案梅械極標機";
		$a.="欠歴残殺毒氏民求治法";
		$a.="泣浅浴清満漁灯無然焼";
		$a.="照熱牧特産的省祝票種";
		$a.="積競笑管節粉紀約結給";
		$a.="続置老胃脈腸臣航良芸";
		$a.="芽英菜街衣要覚観訓試";
		$a.="説課議象貨貯費賞軍輪";
		$a.="辞辺連達選郡量録鏡関";
		$a.="陸隊静順願類飛飯養験";
	}
	else if ($set=="g5")
	{
		$a="久仏仮件任似余価保修";
		$a.="俵個備像再刊判制券則";
		$a.="効務勢厚句可営因団圧";
		$a.="在均基報境墓増夢妻婦";
		$a.="容寄富導居属布師常幹";
		$a.="序弁張往復徳志応快性";
		$a.="恩情態慣承技招授採接";
		$a.="提損支政故敵断旧易暴";
		$a.="条枝査格桜検構武比永";
		$a.="河液混減測準演潔災燃";
		$a.="版犯状独率現留略益眼";
		$a.="破確示祖禁移程税築精";
		$a.="素経統絶綿総編績織罪";
		$a.="群義耕職肥能興舌舎術";
		$a.="衛製複規解設許証評講";
		$a.="謝識護豊財貧責貸貿賀";
		$a.="資賛質輸述迷退逆造過";
		$a.="適酸鉱銅銭防限険際雑";
		$a.="非預領額飼";
	}
	else if ($set=="g6")
	{
		$a="並乱乳亡仁供俳値傷優";
		$a.="党冊処刻割創劇勤危卵";
		$a.="厳収后否吸呼善困垂城";
		$a.="域奏奮姿存孝宅宇宗宙";
		$a.="宝宣密寸専射将尊就尺";
		$a.="届展層己巻幕干幼庁座";
		$a.="延律従忘忠憲我批担拝";
		$a.="拡捨探推揮操敬映晩暖";
		$a.="暮朗机枚染株棒模権樹";
		$a.="欲段沿泉洗派済源潮激";
		$a.="灰熟片班異疑痛皇盛盟";
		$a.="看砂磁私秘穀穴窓筋策";
		$a.="簡糖系紅納純絹縦縮署";
		$a.="翌聖肺背胸脳腹臓臨至";
		$a.="若著蒸蔵蚕衆裁装裏補";
		$a.="視覧討訪訳詞誌認誕誠";
		$a.="誤論諸警貴賃遺郵郷針";
		$a.="鋼閉閣降陛除障難革頂";
		$a.="骨";
	}
	else if ($set=="g7")
	{
		$a="乙了又丈与及乞凡刃巾互丹乏井冗凶刈勾匂匹升厄双介孔";
		$a.="屯幻弔斗斤爪牙且丘丙丼巨仙凹凸占叱召囚奴尻尼巧払氾";
		$a.="汁込斥旦玄瓦甘甲矛伎仰伐伏充刑劣匠企吉叫吐吏壮如妃";
		$a.="妄尽巡帆弐忙扱汎汚汗江芋芝迅旨旬肌朽朱朴缶臼舟串亜";
		$a.="佐伺伸但伯伴克冶励却即呂含吟呉吹呈坑坊壱妖妥妊妨妙";
		$a.="寿尿尾岐床廷弄抗抄択把抜扶抑沙汰沃沖沢沈没狂芯芳迎";
		$a.="那邦阪忌忍戒戻攻更肘肝肖杉秀辛享依佳侍侮併免刹刺到";
		$a.="劾卓叔呪坪奈奇奉奔妬姓宛宜尚屈岡岳岬弥弦征彼怪怖拉";
		$a.="押拐拒拠拘拙拓抽抵拍披抱抹況沼泥泊泌沸泡狙苛茎苗茂";
		$a.="迭迫邪邸阻附房旺昆昇股肩肯肢肪枕枢析杯枠欧殴炎炊炉";
		$a.="采玩祈祉盲突虎阜斉亭侶侯俊侵促俗冠削勃勅卑卸厘叙咽";
		$a.="哀咲垣契威姻孤封峡峠帥帝幽弧悔恒恨拶拭括挟拷挑洪浄";
		$a.="津洞狭狩茨荒荘逃郊郎怨怠怒施昧是胎胆胞柿柵栃架枯柔";
		$a.="柄某柳為牲珍甚畏疫皆盆眉盾冒砕窃糾耐臭虐虹衷訃訂貞";
		$a.="赴軌香俺倹倒倣俸倫兼冥凄准凍剥剣剛剤剖匿唄哺唆唇哲";
		$a.="唐埋娯娠姫娘宴宰宵峰徐悦悟悩挨捉挫振捜挿捕浦浸浜浮";
		$a.="涙浪華逝逐逓途透陥陣恣恐恵恥恋恭扇拳敏脇脊脅脂朕胴";
		$a.="桁核桑栽桟栓桃殊殉烈珠祥泰畝畜畔疾症疲眠砲称租秩袖";
		$a.="被既粋索紛紡紋翁耗致般蚊衰託貢軒辱酎酌釜隻飢鬼竜曹";
		$a.="乾偽偶偵偏剰勘唾喝啓唯埼堆執培婚婆寂尉崖崎崇崩庶庸";
		$a.="彩彫惧惨惜悼捻捗掛掘掲控据措掃排描堀淫涯渇渓渋淑渉";
		$a.="淡添涼猫猛猟葛萎菓菊菌逸逮郭陰陳陶陪隆陵患悠戚斜斬";
		$a.="旋曽脚脱梗梨殻爽瓶痕盗眺窒符粗粘粒紺紹紳累羞粛舷舶";
		$a.="虚蛍蛇袋訟豚貪貫販赦軟酔釈釣頃鹿麻斎亀僅偉傍募傘喉";
		$a.="喩喚喫喪圏堪堅堕塚堤塔塀塁奥媛媒婿尋嵐項幅帽幾廃廊";
		$a.="弾御循慌惰愉握援換搭揚揺湧渦滋湿渡湾猶葬遇遂遅遍隅";
		$a.="随惑扉掌敢斑暁晶替普腕椅椎棺棋棚棟款欺殖煮焦琴畳疎";
		$a.="痩痘痢硬硝硫裕筒粧絞紫絡蛮裂詠詐詔診訴貼越超距軸酢";
		$a.="鈍閑雇雄雰須傲傾傑債催僧勧嗅嗣嘆塞填毀塊塑塗奨嫉嫁";
		$a.="嫌寛寝廉彙微慄慨慎携搾摂搬溺滑溝滞滝漠滅溶猿蓋蓄遡";
		$a.="遜違遣隙隔愚慈愁暇腎腫腺腰楷棄楼歳殿煙煩煎献禍禅痴";
		$a.="睦睡督碁稚窟裾褐裸継羨艇虞虜蜂触詣詮該詰誇詳誉賂賊";
		$a.="賄跡践跳較載酬酪鉛鉢鈴雅雷零飾飽靴頓頑頒鼓僕僚塾墨";
		$a.="奪嫡寡寧彰徴憎慢摘漆漸漬滴漂漫漏蔑遮遭隠慕暦膜概熊";
		$a.="獄瑠瘍罰碑稲端箸箋箇綻維綱緒網腐蜜誓誘豪貌踊辣酵酷";
		$a.="銃銘閥雌需餅駆駄髪魂儀勲舗嘲嘱噴墜墳審寮履幣慶弊影";
		$a.="徹憧憬憤撮撤撲潰潟潤澄潜蔽遵遷慰憂慮戯摯撃摩敷暫膝";
		$a.="膚槽歓璃畿監盤罵罷稽稼稿穂窮窯範縁緩緊締縄衝褒誰謁";
		$a.="請諾賭賜賠賓賦趣踪踏輝輩舞鋭鋳閲震霊餓餌頬駒駐魅黙";
		$a.="儒凝壊墾壌壇壁嬢憶懐憾擁濁濃獲薫薪薦薄還避隣憩曇膳";
		$a.="膨獣磨穏篤緻緯縛繁縫融衡諦謎諧諮謀諭謡賢醒麺錦錮錯";
		$a.="錠錬隷頼骸償嚇擬擦濯懇戴曖臆燥爵犠環療瞳瞭矯礁繊翼";
		$a.="聴謹謙謄購轄醜鍵鍋鍛闇霜韓頻鮮齢濫藤藍藩懲璧癖癒瞬";
		$a.="礎穫襟糧繕繭翻覆贈鎌鎖鎮闘顎顕騎騒瀬藻爆璽羅簿繰艶";
		$a.="覇譜蹴離霧韻髄鯨鶏麓麗懸欄籍譲醸鐘響騰艦躍露顧魔鶴";
		$a.="籠襲驚鑑鬱";
	}
	else if ($set=="frequent2500")
	{
		$a="一乙二十丁厂七卜人入八九几儿了力乃刀又三于干亏士工土才寸下大丈与万上小口巾山千乞川亿个勺久凡及夕丸么广亡门义之尸弓己已子";
		$a.="卫也女飞刃习叉马乡丰王井开夫天无元专云扎艺木五支厅不太犬区历尤友匹车巨牙屯比互切瓦止少日中冈贝内水见午牛手毛气升长仁什片";
		$a.="仆化仇币仍仅斤爪反介父从今凶分乏公仓月氏勿欠风丹匀乌凤勾文六方火为斗忆订计户认心尺引丑巴孔队办以允予劝双书幻玉刊示末未击";
		$a.="打巧正扑扒功扔去甘世古节本术可丙左厉右石布龙平灭轧东卡北占业旧帅归且旦目叶甲申叮电号田由史只央兄叼叫另叨叹四生失禾丘付仗";
		$a.="代仙们仪白仔他斥瓜乎丛令用甩印乐句匆册犯外处冬鸟务包饥主市立闪兰半汁汇头汉宁穴它讨写让礼训必议讯记永司尼民出辽奶奴加召皮";
		$a.="边发孕圣对台矛纠母幼丝式刑动扛寺吉扣考托老执巩圾扩扫地扬场耳共芒亚芝朽朴机权过臣再协西压厌在有百存而页匠夸夺灰达列死成夹";
		$a.="轨邪划迈毕至此贞师尘尖劣光当早吐吓虫曲团同吊吃因吸吗屿帆岁回岂刚则肉网年朱先丢舌竹迁乔伟传乒乓休伍伏优伐延件任伤价份华仰";
		$a.="仿伙伪自血向似后行舟全会杀合兆企众爷伞创肌朵杂危旬旨负各名多争色壮冲冰庄庆亦刘齐交次衣产决充妄闭问闯羊并关米灯州汗污江池";
		$a.="汤忙兴宇守宅字安讲军许论农讽设访寻那迅尽导异孙阵阳收阶阴防奸如妇好她妈戏羽观欢买红纤级约纪驰巡寿弄麦形进戒吞远违运扶抚坛";
		$a.="技坏扰拒找批扯址走抄坝贡攻赤折抓扮抢孝均抛投坟抗坑坊抖护壳志扭块声把报却劫芽花芹芬苍芳严芦劳克苏杆杠杜材村杏极李杨求更束";
		$a.="豆两丽医辰励否还歼来连步坚旱盯呈时吴助县里呆园旷围呀吨足邮男困吵串员听吩吹呜吧吼别岗帐财针钉告我乱利秃秀私每兵估体何但伸";
		$a.="作伯伶佣低你住位伴身皂佛近彻役返余希坐谷妥含邻岔肝肚肠龟免狂犹角删条卵岛迎饭饮系言冻状亩况床库疗应冷这序辛弃冶忘闲间闷判";
		$a.="灶灿弟汪沙汽沃泛沟没沈沉怀忧快完宋宏牢究穷灾良证启评补初社识诉诊词译君灵即层尿尾迟局改张忌际陆阿陈阻附妙妖妨努忍劲鸡驱纯";
		$a.="纱纳纲驳纵纷纸纹纺驴纽奉玩环武青责现表规抹拢拔拣担坦押抽拐拖拍者顶拆拥抵拘势抱垃拉拦拌幸招坡披拨择抬其取苦若茂苹苗英范直";
		$a.="茄茎茅林枝杯柜析板松枪构杰述枕丧或画卧事刺枣雨卖矿码厕奔奇奋态欧垄妻轰顷转斩轮软到非叔肯齿些虎虏肾贤尚旺具果味昆国昌畅明";
		$a.="易昂典固忠咐呼鸣咏呢岸岩帖罗帜岭凯败贩购图钓制知垂牧物乖刮秆和季委佳侍供使例版侄侦侧凭侨佩货依的迫质欣征往爬彼径所舍金命";
		$a.="斧爸采受乳贪念贫肤肺肢肿胀朋股肥服胁周昏鱼兔狐忽狗备饰饱饲变京享店夜庙府底剂郊废净盲放刻育闸闹郑券卷单炒炊炕炎炉沫浅法泄";
		$a.="河沾泪油泊沿泡注泻泳泥沸波泼泽治怖性怕怜怪学宝宗定宜审宙官空帘实试郎诗肩房诚衬衫视话诞询该详建肃录隶居届刷屈弦承孟孤陕降";
		$a.="限妹姑姐姓始驾参艰线练组细驶织终驻驼绍经贯奏春帮珍玻毒型挂封持项垮挎城挠政赴赵挡挺括拴拾挑指垫挣挤拼挖按挥挪某甚革荐巷带";
		$a.="草茧茶荒茫荡荣故胡南药标枯柄栋相查柏柳柱柿栏树要咸威歪研砖厘厚砌砍面耐耍牵残殃轻鸦皆背战点临览竖省削尝是盼眨哄显哑冒映星";
		$a.="昨畏趴胃贵界虹虾蚁思蚂虽品咽骂哗咱响哈咬咳哪炭峡罚贱贴骨钞钟钢钥钩卸缸拜看矩怎牲选适秒香种秋科重复竿段便俩贷顺修保促侮俭";
		$a.="俗俘信皇泉鬼侵追俊盾待律很须叙剑逃食盆胆胜胞胖脉勉狭狮独狡狱狠贸怨急饶蚀饺饼弯将奖哀亭亮度迹庭疮疯疫疤姿亲音帝施闻阀阁差";
		$a.="养美姜叛送类迷前首逆总炼炸炮烂剃洁洪洒浇浊洞测洗活派洽染济洋洲浑浓津恒恢恰恼恨举觉宣室宫宪突穿窃客冠语扁袄祖神祝误诱说诵";
		$a.="垦退既屋昼费陡眉孩除险院娃姥姨姻娇怒架贺盈勇怠柔垒绑绒结绕骄绘给络骆绝绞统耕耗艳泰珠班素蚕顽盏匪捞栽捕振载赶起盐捎捏埋捉";
		$a.="捆捐损都哲逝捡换挽热恐壶挨耻耽恭莲莫荷获晋恶真框桂档桐株桥桃格校核样根索哥速逗栗配翅辱唇夏础破原套逐烈殊顾轿较顿毙致柴桌";
		$a.="虑监紧党晒眠晓鸭晃晌晕蚊哨哭恩唤啊唉罢峰圆贼贿钱钳钻铁铃铅缺氧特牺造乘敌秤租积秧秩称秘透笔笑笋债借值倚倾倒倘俱倡候俯倍倦";
		$a.="健臭射躬息徒徐舰舱般航途拿爹爱颂翁脆脂胸胳脏胶脑狸狼逢留皱饿恋桨浆衰高席准座脊症病疾疼疲效离唐资凉站剖竞部旁旅畜阅羞瓶拳";
		$a.="粉料益兼烤烘烦烧烛烟递涛浙涝酒涉消浩海涂浴浮流润浪浸涨烫涌悟悄悔悦害宽家宵宴宾窄容宰案请朗诸读扇袜袖袍被祥课谁调冤谅谈谊";
		$a.="剥恳展剧屑弱陵陶陷陪娱娘通能难预桑绢绣验继球理捧堵描域掩捷排掉堆推掀授教掏掠培接控探据掘职基著勒黄萌萝菌菜萄菊萍菠营械梦";
		$a.="梢梅检梳梯桶救副票戚爽聋袭盛雪辅辆虚雀堂常匙晨睁眯眼悬野啦晚啄距跃略蛇累唱患唯崖崭崇圈铜铲银甜梨犁移笨笼笛符第敏做袋悠偿";
		$a.="偶偷您售停偏假得衔盘船斜盒鸽悉欲彩领脚脖脸脱象够猜猪猎猫猛馅馆凑减毫麻痒痕廊康庸鹿盗章竟商族旋望率着盖粘粗粒断剪兽清添淋";
		$a.="淹渠渐混渔淘液淡深婆梁渗情惜惭悼惧惕惊惨惯寇寄宿窑密谋谎祸谜逮敢屠弹随蛋隆隐婚婶颈绩绪续骑绳维绵绸绿琴斑替款堪搭塔越趁趋";
		$a.="超提堤博揭喜插揪搜煮援裁搁搂搅握揉斯期欺联散惹葬葛董葡敬葱落朝辜葵棒棋植森椅椒棵棍棉棚棕惠惑逼厨厦硬确雁殖裂雄暂雅辈悲紫";
		$a.="辉敞赏掌晴暑最量喷晶喇遇喊景践跌跑遗蛙蛛蜓喝喂喘喉幅帽赌赔黑铸铺链销锁锄锅锈锋锐短智毯鹅剩稍程稀税筐等筑策筛筒答筋筝傲傅";
		$a.="牌堡集焦傍储奥街惩御循艇舒番释禽腊脾腔鲁猾猴然馋装蛮就痛童阔善羡普粪尊道曾焰港湖渣湿温渴滑湾渡游滋溉愤慌惰愧愉慨割寒富窜";
		$a.="窝窗遍裕裤裙谢谣谦属屡强粥疏隔隙絮嫂登缎缓编骗缘瑞魂肆摄摸填搏塌鼓摆携搬摇搞塘摊蒜勤鹊蓝墓幕蓬蓄蒙蒸献禁楚想槐榆楼概赖酬";
		$a.="感碍碑碎碰碗碌雷零雾雹输督龄鉴睛睡睬鄙愚暖盟歇暗照跨跳跪路跟遣蛾蜂嗓置罪罩错锡锣锤锦键锯矮辞稠愁筹签简毁舅鼠催傻像躲微愈";
		$a.="遥腰腥腹腾腿触解酱痰廉新韵意粮数煎塑慈煤煌满漠源滤滥滔溪溜滚滨粱滩慎誉塞谨福群殿辟障嫌嫁叠缝缠静碧璃墙撇嘉摧截誓境摘摔聚";
		$a.="蔽慕暮蔑模榴榜榨歌遭酷酿酸磁愿需弊裳颗嗽蜻蜡蝇蜘赚锹锻舞稳算箩管僚鼻魄貌膜膊膀鲜疑馒裹敲豪膏遮腐瘦辣竭端旗精歉熄熔漆漂漫";
		$a.="滴演漏慢寨赛察蜜谱嫩翠熊凳骡缩慧撕撒趣趟撑播撞撤增聪鞋蕉蔬横槽樱橡飘醋醉震霉瞒题暴瞎影踢踏踩踪蝶蝴嘱墨镇靠稻黎稿稼箱箭篇";
		$a.="僵躺僻德艘膝膛熟摩颜毅糊遵潜潮懂额慰劈操燕薯薪薄颠橘整融醒餐嘴蹄器赠默镜赞篮邀衡膨雕磨凝辨辩糖糕燃澡激懒壁避缴戴擦鞠藏霜";
		$a.="霞瞧蹈螺穗繁辫赢糟糠燥臂翼骤鞭覆蹦镰翻鹰警攀蹲颤瓣爆疆壤耀躁嚼嚷籍魔灌蠢霸露囊罐";
	}
	else if ($set=="frequentLess1000")
	{
		$a="匕刁丐歹戈夭仑讥冗邓艾夯凸卢叭叽皿凹囚矢乍尔冯玄邦迂邢芋芍吏夷吁吕吆屹廷迄臼仲伦伊肋旭匈凫妆亥汛讳讶讹讼诀弛阱驮驯纫玖玛";
		$a.="韧抠扼汞扳抡坎坞抑拟抒芙芜苇芥芯芭杖杉巫杈甫匣轩卤肖吱吠呕呐吟呛吻吭邑囤吮岖牡佑佃伺囱肛肘甸狈鸠彤灸刨庇吝庐闰兑灼沐沛汰";
		$a.="沥沦汹沧沪忱诅诈罕屁坠妓姊妒纬玫卦坷坯拓坪坤拄拧拂拙拇拗茉昔苛苫苟苞茁苔枉枢枚枫杭郁矾奈奄殴歧卓昙哎咕呵咙呻咒咆咖帕账贬";
		$a.="贮氛秉岳侠侥侣侈卑刽刹肴觅忿瓮肮肪狞庞疟疙疚卒氓炬沽沮泣泞泌沼怔怯宠宛衩祈诡帚屉弧弥陋陌函姆虱叁绅驹绊绎契贰玷玲珊拭拷拱";
		$a.="挟垢垛拯荆茸茬荚茵茴荞荠荤荧荔栈柑栅柠枷勃柬砂泵砚鸥轴韭虐昧盹咧昵昭盅勋哆咪哟幽钙钝钠钦钧钮毡氢秕俏俄俐侯徊衍胚胧胎狰饵";
		$a.="峦奕咨飒闺闽籽娄烁炫洼柒涎洛恃恍恬恤宦诫诬祠诲屏屎逊陨姚娜蚤骇耘耙秦匿埂捂捍袁捌挫挚捣捅埃耿聂荸莽莱莉莹莺梆栖桦栓桅桩贾";
		$a.="酌砸砰砾殉逞哮唠哺剔蚌蚜畔蚣蚪蚓哩圃鸯唁哼唆峭唧峻赂赃钾铆氨秫笆俺赁倔殷耸舀豺豹颁胯胰脐脓逛卿鸵鸳馁凌凄衷郭斋疹紊瓷羔烙";
		$a.="浦涡涣涤涧涕涩悍悯窍诺诽袒谆祟恕娩骏琐麸琉琅措捺捶赦埠捻掐掂掖掷掸掺勘聊娶菱菲萎菩萤乾萧萨菇彬梗梧梭曹酝酗厢硅硕奢盔匾颅";
		$a.="彪眶晤曼晦冕啡畦趾啃蛆蚯蛉蛀唬啰唾啤啥啸崎逻崔崩婴赊铐铛铝铡铣铭矫秸秽笙笤偎傀躯兜衅徘徙舶舷舵敛翎脯逸凰猖祭烹庶庵痊阎阐";
		$a.="眷焊焕鸿涯淑淌淮淆渊淫淳淤淀涮涵惦悴惋寂窒谍谐裆袱祷谒谓谚尉堕隅婉颇绰绷综绽缀巢琳琢琼揍堰揩揽揖彭揣搀搓壹搔葫募蒋蒂韩棱";
		$a.="椰焚椎棺榔椭粟棘酣酥硝硫颊雳翘凿棠晰鼎喳遏晾畴跋跛蛔蜒蛤鹃喻啼喧嵌赋赎赐锉锌甥掰氮氯黍筏牍粤逾腌腋腕猩猬惫敦痘痢痪竣翔奠";
		$a.="遂焙滞湘渤渺溃溅湃愕惶寓窖窘雇谤犀隘媒媚婿缅缆缔缕骚瑟鹉瑰搪聘斟靴靶蓖蒿蒲蓉楔椿楷榄楞楣酪碘硼碉辐辑频睹睦瞄嗜嗦暇畸跷跺";
		$a.="蜈蜗蜕蛹嗅嗡嗤署蜀幌锚锥锨锭锰稚颓筷魁衙腻腮腺鹏肄猿颖煞雏馍馏禀痹廓痴靖誊漓溢溯溶滓溺寞窥窟寝褂裸谬媳嫉缚缤剿赘熬赫蔫摹";
		$a.="蔓蔗蔼熙蔚兢榛榕酵碟碴碱碳辕辖雌墅嘁踊蝉嘀幔镀舔熏箍箕箫舆僧孵瘩瘟彰粹漱漩漾慷寡寥谭褐褪隧嫡缨撵撩撮撬擒墩撰鞍蕊蕴樊樟橄";
		$a.="敷豌醇磕磅碾憋嘶嘲嘹蝠蝎蝌蝗蝙嘿幢镊镐稽篓膘鲤鲫褒瘪瘤瘫凛澎潭潦澳潘澈澜澄憔懊憎翩褥谴鹤憨履嬉豫缭撼擂擅蕾薛薇擎翰噩橱橙";
		$a.="瓢蟥霍霎辙冀踱蹂蟆螃螟噪鹦黔穆篡篷篙篱儒膳鲸瘾瘸糙燎濒憾懈窿缰壕藐檬檐檩檀礁磷瞭瞬瞳瞪曙蹋蟋蟀嚎赡镣魏簇儡徽爵朦臊鳄糜癌";
		$a.="懦豁臀藕藤瞻嚣鳍癞瀑襟璧戳攒孽蘑藻鳖蹭蹬簸簿蟹靡癣羹鬓攘蠕巍鳞糯譬霹躏髓蘸镶瓤矗";
	}
	return $a;
}
function navigation($lang)
{
	$lm=7;
	echo "<div class='navigation'>";
	if ($lang=="Ja")
	{
		for ($l=0;$l<($lm-1);$l++)
		{
			echo "<a href=\"#g".($l+1)."\">Grade ".($l+1)."</a>";
		}
		echo "<a href=\"#g7\">Junior high school</a>";
	}
	else
	{
		for ($l=0;$l<$lm;$l++)
		{
			echo "<a href=\"#p".($l+1)."\">Part ".($l+1)."</a>";
		}
	}
	echo "<a href=\"#top\">Top</a>";
	echo "<a href=\"#bottom\">Bottom</a>";
	echo "</div>\n";
}
function decUnicode($u)
{
    $k=mb_convert_encoding($u,'UCS-2LE','UTF-8');
    $len=strlen($k);
    $k1=ord(substr($k,0,1));
    if ($len>1) $k2=ord(substr($k,1,1));else $k2=0;
    return $k2*256+$k1;
}
function check($char)
{
	$dec=decUnicode($char);
	$jaFile="svgsJa/".$dec.".svg";
	$zhHansFile="svgsZhHans/".$dec.".svg";
	$inJa=file_exists($jaFile);
	$inZhHans=file_exists($zhHansFile);
	if ($inJa&&$inZhHans)
	{
		if (file_get_contents($jaFile)==file_get_contents($zhHansFile)) return "sameInBoth";
		else return "notSameInBoth";
	}
	else return "notInBoth";
}
?>
<section id="joyoSection" lang="ja">
<?php
$a=array();
$b="";
$lm=7;
for ($l=0;$l<$lm;$l++) {$a[$l]=getCharList("g".($l+1));$b.=$a[$l];}
$km=mb_strlen($b,'UTF-8');
echo "<h2>Jōyō kanji (".$km." characters)</h2>\n";
echo "<p><span class=\"sameInBoth\">Black</span> Same in Japanese and Chinese</p>\n";
echo "<p><span class=\"notSameInBoth\">Blue</span> Different in Japanese and Chinese</p>\n";
echo "<p><span class=\"notInBoth\">Green</span> Not frequently used in Chinese</p>\n";
echo "<p>The difference can be the stroke order, a stroke direction, the number of stroke or the glyph itself.</p>\n";
for ($l=0;$l<$lm;$l++)
{
	navigation("Ja");
	$km=mb_strlen($a[$l],'UTF-8');
	if ($l<6) echo "<h3 id='g".($l+1)."'>Grade ".($l+1)." (".$km." characters)</h3>\n";
	else echo "<h3 id='g".($l+1)."'>Junior high school (".$km." characters)</h3>\n";
	echo "<div>";
	for ($k=0;$k<$km;$k++)
	{
		$u=mb_substr($a[$l],$k,1,'UTF-8');
		echo "<button class=\"".check($u)."\" onclick=\"doIt('".$u."')\">".$u."</button>\n";
	}
	echo "</div>\n";
}
?>
</section>
<section id="frequentSection" lang="zh-Hans">
<?php
$c1=getCharList("frequent2500");
$c2=getCharList("frequentLess1000");
$c=$c1.$c2;
$km=mb_strlen($c,'UTF-8');
echo "<h2>Frequently used simplified hanzi (".$km." characters)</h2>\n";
echo "<p><span class=\"sameInBoth\">Black</span> Same in Chinese and Japanese</p>\n";
echo "<p><span class=\"notSameInBoth\">Blue</span> Different in Chinese and Japanese (stroke order, stroke direction, number of stroke or glyph)</p>\n";
echo "<p><span class=\"notInBoth\">Green</span> Not frequently used in japanese</p>\n";
echo "<p>The difference can be the stroke order, a stroke direction, the number of stroke or the glyph itself.</p>\n";
$l=0;
for ($k=0;$k<$km;$k++)
{
	if (($k/500)==intval($k/500))
	{
		$l++;
		if ($k!=0) echo "</div>\n";
		navigation("ZhHans");
		echo "<h3 id='p".$l."'>Part ".$l."</h3>\n";
		echo "<div>";
	}
	$u=mb_substr($c,$k,1,'UTF-8');
	echo "<button class=\"".check($u)."\" onclick=\"doIt('".$u."')\">".$u."</button>\n";
	if ($k==($km-1)) echo "</div>\n";
}
?>
</section>
<footer>
<div id="bottom" class="link"><a href="#top">Top</a></div>
<a href="licenses/COPYING.txt">Licences</a>
- <a href="https://github.com/parsimonhi/animCJK">Download</a><br>
Copyright 2016-2017 - François Mizessyn
</footer>
<script>
document.getElementById("data").addEventListener("keyup",function(event) {
	event.preventDefault();
	if (event.keyCode==13) ok();
});
</script>
</body>
</html>