<!--
cityareacode = new Array();
cityarea = new Array();
cityarea_account = new Array();

cityarea_account[0] = 0;

cityarea[1] = '仁愛區';//基隆市
cityarea[2] = '信義區';
cityarea[3] = '中正區';
cityarea[4] = '中山區';
cityarea[5] = '安樂區';
cityarea[6] = '暖暖區';
cityarea[7] = '七堵區';
cityarea_account[1] = 7;

cityarea[8] = '中正區';//台北市
cityarea[9] = '大同區';
cityarea[10] = '中山區';
cityarea[11] = '松山區';
cityarea[12] = '大安區';
cityarea[13] = '萬華區';
cityarea[14] = '信義區';
cityarea[15] = '士林區';
cityarea[16] = '北投區';
cityarea[17] = '內湖區';
cityarea[18] = '南港區';
cityarea[19] = '文山區';
cityarea_account[2] = 19;

cityarea[20] = '八里區';//新北市
cityarea[21] = '三峽區';
cityarea[22] = '樹林區';
cityarea[23] = '鶯歌區';
cityarea[24] = '三重區';
cityarea[25] = '新莊區';
cityarea[26] = '泰山區';
cityarea[27] = '林口區';
cityarea[28] = '三芝區';
cityarea[29] = '五股區';
cityarea[30] = '淡水區';
cityarea[31] = '土城區';
cityarea[32] = '新店區';
cityarea[33] = '蘆洲區';
cityarea[34] = '金山區';
cityarea[35] = '烏來區';
cityarea[36] = '萬里區';
cityarea[37] = '中和區';
cityarea[38] = '板橋區';
cityarea[39] = '汐止區';
cityarea[40] = '深坑區';
cityarea[41] = '石碇區';
cityarea[42] = '平溪區';
cityarea[43] = '雙溪區';
cityarea[44] = '貢寮區';
cityarea[45] = '石門區';
cityarea[46] = '坪林區';
cityarea[47] = '永和區';
cityarea[48] = '瑞芳區';
cityarea_account[3] = 48;

cityarea[49] = '復興鄉';//桃園縣
cityarea[50] = '平鎮市';
cityarea[51] = '龍潭鄉';
cityarea[52] = '楊梅鎮';
cityarea[53] = '新屋鄉';
cityarea[54] = '觀音鄉';
cityarea[55] = '桃園市';
cityarea[56] = '龜山鄉';
cityarea[57] = '蘆竹鄉';
cityarea[58] = '大溪鎮';
cityarea[59] = '大園鄉';
cityarea[60] = '中壢市';
cityarea[61] = '八德市';
cityarea_account[4] = 61;

cityarea[62] = '東區/北區/香山區';//新竹市
cityarea_account[5] = 62;

cityarea[63] = '新豐鄉';//新竹縣
cityarea[64] = '竹北市';
cityarea[65] = '峨眉鄉';
cityarea[66] = '湖口鄉';
cityarea[67] = '新埔鎮';
cityarea[68] = '關西鎮';
cityarea[69] = '寶山鄉';
cityarea[70] = '竹東鎮';
cityarea[71] = '五峰鄉';
cityarea[72] = '橫山鄉';
cityarea[73] = '芎林鄉';
cityarea[74] = '北埔鄉';
cityarea[75] = '尖石鄉';
cityarea_account[6] = 75;

cityarea[76] = '西湖鄉';//苗栗縣
cityarea[77] = '公館鄉';
cityarea[78] = '大湖鄉';
cityarea[79] = '泰安鄉';
cityarea[80] = '卓蘭鎮';
cityarea[81] = '三義鄉';
cityarea[82] = '頭屋鄉';
cityarea[83] = '南庄鄉';
cityarea[84] = '銅鑼鄉';
cityarea[85] = '造橋鄉';
cityarea[86] = '苗栗市';
cityarea[87] = '苑裡鎮';
cityarea[88] = '通霄鎮';
cityarea[89] = '獅潭鄉';
cityarea[90] = '三灣鄉';
cityarea[91] = '頭份鎮';
cityarea[92] = '竹南鎮';
cityarea[93] = '後龍鎮';
cityarea_account[7] = 93;

cityarea[94] = '南屯區';//台中市
cityarea[95] = '西屯區';
cityarea[96] = '北區';
cityarea[97] = '北屯區';
cityarea[98] = '南區';
cityarea[99] = '中區';
cityarea[100] = '西區';
cityarea[101] = '東區';
cityarea[102] = '大肚區';
cityarea[103] = '大安區';
cityarea[104] = '外埔區';
cityarea[105] = '大甲區';
cityarea[106] = '清水區';
cityarea[107] = '梧棲區';
cityarea[108] = '沙鹿區';
cityarea[109] = '神岡區';
cityarea[110] = '大雅區';
cityarea[111] = '潭子區';
cityarea[112] = '豐原區';
cityarea[113] = '龍井區';
cityarea[114] = '新社區';
cityarea[115] = '太平區';
cityarea[116] = '烏日區';
cityarea[117] = '大里區';
cityarea[118] = '后里區';
cityarea[119] = '石岡區';
cityarea[120] = '東勢區';
cityarea[121] = '和平區';
cityarea[122] = '霧峰區';
cityarea_account[8] = 122;

cityarea[123] = '埔鹽鄉';//彰化縣
cityarea[124] = '大村鄉';
cityarea[125] = '田中鎮';
cityarea[126] = '北斗鎮';
cityarea[127] = '二水鄉';
cityarea[128] = '埤頭鄉';
cityarea[129] = '竹塘鄉';
cityarea[130] = '二林鎮';
cityarea[131] = '芳苑鄉';
cityarea[132] = '溪湖鎮';
cityarea[133] = '田尾鄉';
cityarea[134] = '大城鄉';
cityarea[135] = '秀水鄉';
cityarea[136] = '埔心鄉';
cityarea[137] = '溪州鄉';
cityarea[138] = '彰化市';
cityarea[139] = '花壇鄉';
cityarea[140] = '鹿港鎮';
cityarea[141] = '福興鄉';
cityarea[142] = '線西鄉';
cityarea[143] = '和美鎮';
cityarea[144] = '伸港鄉';
cityarea[145] = '員林鎮';
cityarea[146] = '社頭鄉';
cityarea[147] = '永靖鄉';
cityarea[148] = '芬園鄉';
cityarea_account[9] = 148;

cityarea[149] = '中寮鄉';//南投縣
cityarea[150] = '集集鎮';
cityarea[151] = '國姓鄉';
cityarea[152] = '埔里鎮';
cityarea[153] = '仁愛鄉';
cityarea[154] = '名間鄉';
cityarea[155] = '水里鄉';
cityarea[156] = '魚池鄉';
cityarea[157] = '信義鄉';
cityarea[158] = '草屯鎮';
cityarea[159] = '南投市';
cityarea[160] = '鹿谷鄉';
cityarea[161] = '竹山鎮';
cityarea_account[10] = 161;

cityarea[162] = '土庫鎮';//雲林縣
cityarea[163] = '古坑鄉';
cityarea[164] = '斗南鎮';
cityarea[165] = '大埤鄉';
cityarea[166] = '虎尾鎮';
cityarea[167] = '北港鎮';
cityarea[168] = '元長鄉';
cityarea[169] = '四湖鄉';
cityarea[170] = '斗六市';
cityarea[171] = '水林鄉';
cityarea[172] = '褒忠鄉';
cityarea[173] = '二崙鄉';
cityarea[174] = '西螺鎮';
cityarea[175] = '莿桐鄉';
cityarea[176] = '林內鄉';
cityarea[177] = '麥寮鄉';
cityarea[178] = '崙背鄉';
cityarea[179] = '台西鄉';
cityarea[180] = '東勢鄉';
cityarea[181] = '口湖鄉';
cityarea_account[11] = 181;

cityarea[182] = '東區/西區';//嘉義市
cityarea_account[12] = 182;

cityarea[183] = '大埔鄉';//嘉義縣
cityarea[184] = '番路鄉';
cityarea[185] = '梅山鄉';
cityarea[186] = '竹崎鄉';
cityarea[187] = '六腳鄉';
cityarea[188] = '中埔鄉';
cityarea[189] = '布袋鎮';
cityarea[190] = '義竹鄉';
cityarea[191] = '溪口鄉';
cityarea[192] = '大林鎮';
cityarea[193] = '新港鄉';
cityarea[194] = '東石鄉';
cityarea[195] = '朴子市';
cityarea[196] = '太保市';
cityarea[197] = '鹿草鄉';
cityarea[198] = '水上鄉';
cityarea[199] = '阿里山';
cityarea[200] = '民雄鄉';
cityarea_account[13] = 200;

cityarea[201] = '南區';//台南市
cityarea[202] = '北區';
cityarea[203] = '安南區';
cityarea[204] = '東區';
cityarea[205] = '中西區';
cityarea[206] = '安平區';
cityarea[207] = '善化區';
cityarea[208] = '學甲區';
cityarea[209] = '新營區';
cityarea[210] = '白河區';
cityarea[211] = '東山區';
cityarea[212] = '六甲區';
cityarea[213] = '下營區';
cityarea[214] = '鹽水區';
cityarea[215] = '北門區';
cityarea[216] = '大內區';
cityarea[217] = '山上區';
cityarea[218] = '新市區';
cityarea[219] = '安定區';
cityarea[220] = '將軍區';
cityarea[221] = '柳營區';
cityarea[222] = '南化區';
cityarea[223] = '七股區';
cityarea[224] = '歸仁區';
cityarea[225] = '新化區';
cityarea[226] = '左鎮區';
cityarea[227] = '後壁區';
cityarea[228] = '楠西區';
cityarea[229] = '仁德區';
cityarea[230] = '關廟區';
cityarea[231] = '龍崎區';
cityarea[232] = '官田區';
cityarea[233] = '麻豆區';
cityarea[234] = '佳里區';
cityarea[235] = '永康區';
cityarea[236] = '西港區';
cityarea[237] = '玉井區';
cityarea_account[14] = 237;

cityarea[238] = '鹽埕區';//高雄市
cityarea[239] = '左營區';
cityarea[240] = '小港區';
cityarea[241] = '楠梓區';
cityarea[242] = '三民區';
cityarea[243] = '前鎮區';
cityarea[244] = '苓雅區';
cityarea[245] = '前金區';
cityarea[246] = '新興區';
cityarea[247] = '鼓山區';
cityarea[248] = '旗津區';
cityarea[249] = '桃源區';
cityarea[250] = '大寮區';
cityarea[251] = '林園區';
cityarea[252] = '鳥松區';
cityarea[253] = '茄萣區';
cityarea[254] = '旗山區';
cityarea[255] = '六龜區';
cityarea[256] = '內門區';
cityarea[257] = '甲仙區';
cityarea[258] = '三民區';
cityarea[259] = '茂林區';
cityarea[260] = '大樹區';
cityarea[261] = '鳳山區';
cityarea[262] = '杉林區';
cityarea[263] = '岡山區';
cityarea[264] = '美濃區';
cityarea[265] = '仁武區';
cityarea[266] = '大社區';
cityarea[267] = '湖內區';
cityarea[268] = '路竹區';
cityarea[269] = '阿蓮區';
cityarea[270] = '彌陀區';
cityarea[271] = '永安區';
cityarea[272] = '田寮區';
cityarea[273] = '梓官區';
cityarea[274] = '橋頭區';
cityarea[275] = '燕巢區';
cityarea_account[15] = 275;

cityarea[276] = '林邊鄉';//屏東縣
cityarea[277] = '春日鄉';
cityarea[278] = '內埔鄉';
cityarea[279] = '潮州鎮';
cityarea[280] = '來義鄉';
cityarea[281] = '萬巒鄉';
cityarea[282] = '崁頂鄉';
cityarea[283] = '新埤鄉';
cityarea[284] = '南州鄉';
cityarea[285] = '泰武鄉';
cityarea[286] = '東港鎮';
cityarea[287] = '琉球鄉';
cityarea[288] = '佳冬鄉';
cityarea[289] = '新園鄉';
cityarea[290] = '麟洛鄉';
cityarea[291] = '枋山鄉';
cityarea[292] = '竹田鄉';
cityarea[293] = '獅子鄉';
cityarea[294] = '車城鄉';
cityarea[295] = '牡丹鄉';
cityarea[296] = '恆春鎮';
cityarea[297] = '滿州鄉';
cityarea[298] = '枋寮鄉';
cityarea[299] = '霧台鄉';
cityarea[300] = '萬丹鄉';
cityarea[301] = '三地門';
cityarea[302] = '長治鄉';
cityarea[303] = '瑪家鄉';
cityarea[304] = '九如鄉';
cityarea[305] = '高樹鄉';
cityarea[306] = '屏東市';
cityarea[307] = '里港鄉';
cityarea[308] = '鹽埔鄉';
cityarea_account[16] = 308;

cityarea[309] = '東河鄉';//台東縣
cityarea[310] = '台東市';
cityarea[311] = '綠島鄉';
cityarea[312] = '延平鄉';
cityarea[313] = '達仁鄉';
cityarea[314] = '卑南鄉';
cityarea[315] = '鹿野鄉';
cityarea[316] = '關山鎮';
cityarea[317] = '海端鄉';
cityarea[318] = '金峰鄉';
cityarea[319] = '太麻里';
cityarea[320] = '長濱鄉';
cityarea[321] = '成功鎮';
cityarea[322] = '大武鄉';
cityarea[323] = '池上鄉';
cityarea[324] = '蘭嶼鄉';
cityarea_account[17] = 324;

cityarea[325] = '瑞穗鄉';//花蓮縣
cityarea[326] = '玉里鎮';
cityarea[327] = '卓溪鄉';
cityarea[328] = '萬榮鄉';
cityarea[329] = '富里鄉';
cityarea[330] = '豐濱鄉';
cityarea[331] = '光復鄉';
cityarea[332] = '鳳林鎮';
cityarea[333] = '壽豐鄉';
cityarea[334] = '吉安鄉';
cityarea[335] = '秀林鄉';
cityarea[336] = '花蓮市';
cityarea[337] = '新城鄉';
cityarea_account[18] = 337;

cityarea[338] = '南澳鄉';//宜蘭縣
cityarea[339] = '宜蘭市';
cityarea[340] = '頭城鎮';
cityarea[341] = '礁溪鄉';
cityarea[342] = '壯圍鄉';
cityarea[343] = '員山鄉';
cityarea[344] = '羅東鎮';
cityarea[345] = '三星鄉';
cityarea[346] = '大同鄉';
cityarea[347] = '五結鄉';
cityarea[348] = '蘇澳鎮';
cityarea[349] = '冬山鄉';
cityarea_account[19] = 349;

cityarea[350] = '馬公市';//澎湖縣
cityarea[351] = '望安鄉';
cityarea[352] = '七美鄉';
cityarea[353] = '白沙鄉';
cityarea[354] = '湖西鄉';
cityarea[355] = '西嶼鄉';
cityarea_account[20] = 355;

cityarea[356] = '金寧鄉';//金門縣
cityarea[357] = '金湖鎮';
cityarea[358] = '金城鎮';
cityarea[359] = '烈嶼鄉';
cityarea[360] = '烏坵鄉';
cityarea[361] = '金沙鎮';
cityarea_account[21] = 361;

cityarea[362] = '南竿鄉';//連江縣
cityarea[363] = '東引鄉';
cityarea[364] = '莒光鄉';
cityarea[365] = '北竿鄉';
cityarea_account[22] = 365;

cityarea[366] = '南沙';
cityarea[367] = '東沙';
cityarea[368] = '釣魚台';
cityarea_account[23] = 368;

cityarea[369] = '其它';
cityarea_account[24] = 369;

city_account = 24;

cityareacode[1]='200';
cityareacode[2]='201';
cityareacode[3]='202';
cityareacode[4]='203';
cityareacode[5]='204';
cityareacode[6]='205';
cityareacode[7]='206';

cityareacode[8]='100';
cityareacode[9]='103';
cityareacode[10]='104';
cityareacode[11]='105';
cityareacode[12]='106';
cityareacode[13]='108';
cityareacode[14]='110';
cityareacode[15]='111';
cityareacode[16]='112';
cityareacode[17]='114';
cityareacode[18]='115';
cityareacode[19]='116';

cityareacode[20]='249';
cityareacode[21]='237';
cityareacode[22]='238';
cityareacode[23]='239';
cityareacode[24]='241';
cityareacode[25]='242';
cityareacode[26]='243';
cityareacode[27]='244';
cityareacode[28]='252';
cityareacode[29]='248';
cityareacode[30]='251';
cityareacode[31]='236';
cityareacode[32]='231';
cityareacode[33]='247';
cityareacode[34]='208';
cityareacode[35]='233';
cityareacode[36]='207';
cityareacode[37]='235';
cityareacode[38]='220';
cityareacode[39]='221';
cityareacode[40]='222';
cityareacode[41]='223';
cityareacode[42]='226';
cityareacode[43]='227';
cityareacode[44]='228';
cityareacode[45]='253';
cityareacode[46]='232';
cityareacode[47]='234';
cityareacode[48]='224';

cityareacode[49]='336';
cityareacode[50]='324';
cityareacode[51]='325';
cityareacode[52]='326';
cityareacode[53]='327';
cityareacode[54]='328';
cityareacode[55]='330';
cityareacode[56]='333';
cityareacode[57]='338';
cityareacode[58]='335';
cityareacode[59]='337';
cityareacode[60]='320';
cityareacode[61]='334';

cityareacode[62]='300';

cityareacode[63]='304';
cityareacode[64]='302';
cityareacode[65]='315';
cityareacode[66]='303';
cityareacode[67]='305';
cityareacode[68]='306';
cityareacode[69]='308';
cityareacode[70]='310';
cityareacode[71]='311';
cityareacode[72]='312';
cityareacode[73]='307';
cityareacode[74]='314';
cityareacode[75]='313';

cityareacode[76]='368';
cityareacode[77]='363';
cityareacode[78]='364';
cityareacode[79]='365';
cityareacode[80]='369';
cityareacode[81]='367';
cityareacode[82]='362';
cityareacode[83]='353';
cityareacode[84]='366';
cityareacode[85]='361';
cityareacode[86]='360';
cityareacode[87]='358';
cityareacode[88]='357';
cityareacode[89]='354';
cityareacode[90]='352';
cityareacode[91]='351';
cityareacode[92]='350';
cityareacode[93]='356';

cityareacode[94]='408';
cityareacode[95]='407';
cityareacode[96]='404';
cityareacode[97]='406';
cityareacode[98]='402';
cityareacode[99]='400';
cityareacode[100]='403';
cityareacode[101]='401';

cityareacode[102]='432';
cityareacode[103]='439';
cityareacode[104]='438';
cityareacode[105]='437';
cityareacode[106]='436';
cityareacode[107]='435';
cityareacode[108]='433';
cityareacode[109]='429';
cityareacode[110]='428';
cityareacode[111]='427';
cityareacode[112]='420';
cityareacode[113]='434';
cityareacode[114]='426';
cityareacode[115]='411';
cityareacode[116]='414';
cityareacode[117]='412';
cityareacode[118]='421';
cityareacode[119]='422';
cityareacode[120]='423';
cityareacode[121]='424';
cityareacode[122]='413';

cityareacode[123]='516';
cityareacode[124]='515';
cityareacode[125]='520';
cityareacode[126]='521';
cityareacode[127]='530';
cityareacode[128]='523';
cityareacode[129]='525';
cityareacode[130]='526';
cityareacode[131]='528';
cityareacode[132]='514';
cityareacode[133]='522';
cityareacode[134]='527';
cityareacode[135]='504';
cityareacode[136]='513';
cityareacode[137]='524';
cityareacode[138]='500';
cityareacode[139]='503';
cityareacode[140]='505';
cityareacode[141]='506';
cityareacode[142]='507';
cityareacode[143]='508';
cityareacode[144]='509';
cityareacode[145]='510';
cityareacode[146]='511';
cityareacode[147]='512';
cityareacode[148]='502';

cityareacode[149]='541';
cityareacode[150]='552';
cityareacode[151]='544';
cityareacode[152]='545';
cityareacode[153]='546';
cityareacode[154]='551';
cityareacode[155]='553';
cityareacode[156]='555';
cityareacode[157]='556';
cityareacode[158]='542';
cityareacode[159]='540';
cityareacode[160]='558';
cityareacode[161]='557';

cityareacode[162]='633';
cityareacode[163]='646';
cityareacode[164]='630';
cityareacode[165]='631';
cityareacode[166]='632';
cityareacode[167]='651';
cityareacode[168]='655';
cityareacode[169]='654';
cityareacode[170]='640';
cityareacode[171]='652';
cityareacode[172]='634';
cityareacode[173]='649';
cityareacode[174]='648';
cityareacode[175]='647';
cityareacode[176]='643';
cityareacode[177]='638';
cityareacode[178]='637';
cityareacode[179]='636';
cityareacode[180]='635';
cityareacode[181]='653';

cityareacode[182]='600';
cityareacode[183]='607';
cityareacode[184]='602';
cityareacode[185]='603';
cityareacode[186]='604';
cityareacode[187]='615';
cityareacode[188]='606';
cityareacode[189]='625';
cityareacode[190]='624';
cityareacode[191]='623';
cityareacode[192]='622';
cityareacode[193]='616';
cityareacode[194]='614';
cityareacode[195]='613';
cityareacode[196]='612';
cityareacode[197]='611';
cityareacode[198]='608';
cityareacode[199]='605';
cityareacode[200]='621';

cityareacode[201]='702';
cityareacode[202]='704';
cityareacode[203]='709';
cityareacode[204]='701';
cityareacode[205]='700';
cityareacode[206]='708';

cityareacode[207]='741';
cityareacode[208]='726';
cityareacode[209]='730';
cityareacode[210]='732';
cityareacode[211]='733';
cityareacode[212]='734';
cityareacode[213]='735';
cityareacode[214]='737';
cityareacode[215]='727';
cityareacode[216]='742';
cityareacode[217]='743';
cityareacode[218]='744';
cityareacode[219]='745';
cityareacode[220]='725';
cityareacode[221]='736';
cityareacode[222]='716';
cityareacode[223]='724';
cityareacode[224]='711';
cityareacode[225]='712';
cityareacode[226]='713';
cityareacode[227]='731';
cityareacode[228]='715';
cityareacode[229]='717';
cityareacode[230]='718';
cityareacode[231]='719';
cityareacode[232]='720';
cityareacode[233]='721';
cityareacode[234]='722';
cityareacode[235]='710';
cityareacode[236]='723';
cityareacode[237]='714';

cityareacode[238]='803';
cityareacode[239]='813';
cityareacode[240]='812';
cityareacode[241]='811';
cityareacode[242]='807';
cityareacode[243]='806';
cityareacode[244]='802';
cityareacode[245]='801';
cityareacode[246]='800';
cityareacode[247]='804';
cityareacode[248]='805';

cityareacode[249]='848';
cityareacode[250]='831';
cityareacode[251]='832';
cityareacode[252]='833';
cityareacode[253]='852';
cityareacode[254]='842';
cityareacode[255]='844';
cityareacode[256]='845';
cityareacode[257]='847';
cityareacode[258]='849';
cityareacode[259]='851';
cityareacode[260]='840';
cityareacode[261]='830';
cityareacode[262]='846';
cityareacode[263]='820';
cityareacode[264]='843';
cityareacode[265]='814';
cityareacode[266]='815';
cityareacode[267]='829';
cityareacode[268]='821';
cityareacode[269]='822';
cityareacode[270]='827';
cityareacode[271]='828';
cityareacode[272]='823';
cityareacode[273]='826';
cityareacode[274]='825';
cityareacode[275]='824';

cityareacode[276]='927';
cityareacode[277]='942';
cityareacode[278]='912';
cityareacode[279]='920';
cityareacode[280]='922';
cityareacode[281]='923';
cityareacode[282]='924';
cityareacode[283]='925';
cityareacode[284]='926';
cityareacode[285]='921';
cityareacode[286]='928';
cityareacode[287]='929';
cityareacode[288]='931';
cityareacode[289]='932';
cityareacode[290]='909';
cityareacode[291]='941';
cityareacode[292]='911';
cityareacode[293]='943';
cityareacode[294]='944';
cityareacode[295]='945';
cityareacode[296]='946';
cityareacode[297]='947';
cityareacode[298]='940';
cityareacode[299]='902';
cityareacode[300]='913';
cityareacode[301]='901';
cityareacode[302]='908';
cityareacode[303]='903';
cityareacode[304]='904';
cityareacode[305]='906';
cityareacode[306]='900';
cityareacode[307]='905';
cityareacode[308]='907';

cityareacode[309]='959';
cityareacode[310]='950';
cityareacode[311]='951';
cityareacode[312]='953';
cityareacode[313]='966';
cityareacode[314]='954';
cityareacode[315]='955';
cityareacode[316]='956';
cityareacode[317]='957';
cityareacode[318]='964';
cityareacode[319]='963';
cityareacode[320]='962';
cityareacode[321]='961';
cityareacode[322]='965';
cityareacode[323]='958';
cityareacode[324]='952';

cityareacode[325]='978';
cityareacode[326]='981';
cityareacode[327]='982';
cityareacode[328]='979';
cityareacode[329]='983';
cityareacode[330]='977';
cityareacode[331]='976';
cityareacode[332]='975';
cityareacode[333]='974';
cityareacode[334]='973';
cityareacode[335]='972';
cityareacode[336]='970';
cityareacode[337]='971';

cityareacode[338]='272';
cityareacode[339]='260';
cityareacode[340]='261';
cityareacode[341]='262';
cityareacode[342]='263';
cityareacode[343]='264';
cityareacode[344]='265';
cityareacode[345]='266';
cityareacode[346]='267';
cityareacode[347]='268';
cityareacode[348]='270';
cityareacode[349]='269';

cityareacode[350]='880';
cityareacode[351]='882';
cityareacode[352]='883';
cityareacode[353]='884';
cityareacode[354]='885';
cityareacode[355]='881';

cityareacode[356]='892';
cityareacode[357]='891';
cityareacode[358]='893';
cityareacode[359]='894';
cityareacode[360]='896';
cityareacode[361]='890';

cityareacode[362]='209';
cityareacode[363]='212';
cityareacode[364]='211';
cityareacode[365]='210';

cityareacode[366] = '819';
cityareacode[367] = '817';
cityareacode[368] = '290';

cityareacode[369] = '';

function citychange(form) {
	i = form.Area.selectedIndex + 1;
	form.cityarea.length = cityarea_account[i] - cityarea_account[i-1];
	index = cityarea_account[i-1] + 1;
	for (j = 0; j < form.cityarea.length; j ++) {
		form.cityarea.options[j].value = cityarea[index + j];
		form.cityarea.options[j].text = cityarea[index + j];
	}
	form.Mcode.value = cityareacode[cityarea_account[i-1]+1];
	form.cuszip.value = cityareacode[cityarea_account[i-1]+1];
	form.cityarea.options[0].selected = true;
	i = form.cityarea.selectedIndex;
	form.cusadr.value = form.Area.options[form.Area.selectedIndex].value+form.cityarea.options[form.cityarea.selectedIndex].value;
}
function areachange(form) {
	i = form.cityarea.selectedIndex;
	form.Mcode.value = cityareacode[cityarea_account[form.Area.selectedIndex]+i+1];
	form.cuszip.value = cityareacode[cityarea_account[form.Area.selectedIndex]+i+1];
	form.cusadr.value = form.Area.options[form.Area.selectedIndex].value+form.cityarea.options[form.cityarea.selectedIndex].value;
}

function citychange2(form) {
	i = form.Area2.selectedIndex + 1;
	form.cityarea2.length = cityarea_account[i] - cityarea_account[i-1];
	index = cityarea_account[i-1] + 1;
	for (j = 0; j < form.cityarea2.length; j ++) {
		form.cityarea2.options[j].value = cityarea[index + j];
		form.cityarea2.options[j].text = cityarea[index + j];
	}
	form.Mcode2.value = cityareacode[cityarea_account[i-1]+1];
	form.cuszip2.value = cityareacode[cityarea_account[i-1]+1];
	form.cityarea2.options[0].selected = true;
	i = form.cityarea2.selectedIndex;
	form.cusadr2.value = form.Area2.options[form.Area2.selectedIndex].value+form.cityarea2.options[form.cityarea2.selectedIndex].value;
}
function areachange2(form) {
	i = form.cityarea2.selectedIndex;
	form.Mcode2.value = cityareacode[cityarea_account[form.Area2.selectedIndex]+i+1];
	form.cuszip2.value = cityareacode[cityarea_account[form.Area2.selectedIndex]+i+1];
	form.cusadr2.value = form.Area2.options[form.Area2.selectedIndex].value+form.cityarea2.options[form.cityarea2.selectedIndex].value;
}