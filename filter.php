<?php
/**
 * Remove duplicate links
 */
$filter=array(
	/* real link http://herveleblouch.free.fr/liens/index.php5?do=rss */
	"http://herveleblouch.free.fr/liens/5?do=rss",
	"http://herveleblouch.free.fr/liens/5/?do=rss",

	/* real link http://tools.aldarone.fr/share/?do=rss */
	"http://share.aldarone.fr/?do=rss",

	/* real link https://liens.strak.ch/?do=rss */
	"https://strak.ch/liens/?do=rss",
	"http://strak.ch/liens/?do=rss",

	/* real link http://shaarli.chassegnouf.net/?do=rss */
	"http://www.chassegnouf.net/links/?do=rss",

	/* real link http://raphael.nicola.free.fr/Shaarli/index.php5?do=rss */
	"http://akrilon.free.fr/shaarly/index.php5?do=rss",

	/* HS */
	"http://www.dadall.info/links/?do=rss",

	/* HS */
	"http://fchaix.eu/shaarli/?do=rss",

	/* HS */
	"http://share.no-life.info/?do=rss",

	/* HS */
	"http://shaarli.waah.info/?do=rss",

	/* real link http://www.ngourillon.com/shaarli/?do=rss */
	"http://www.ngourillon.com/shaarli/?do=rss",

	/* HS */
	"http://comptoir-du-net.fr/cafeline/shaarli/?do=rss",

	/* HS */
	"http://dooby.fr/links/?do=rss",

	/* real link http://share-link.olympe.in/?do=rss */
	"http://share-link.0pu.ru/?do=rss",

	/* real link http://peacecopathe.free.fr/peacecoLiens/?do=rss */
	"http://peacecopathe.free.fr/peacecoLiens/5?do=rss",

	/* real link http://deleurme.net/liens/?do=rss */
	"http://deleurme.net/liens/5/?do=rss",

	/* real link http://lalleau.com.free.fr/?do=rss */
	"http://lalleau.com.free.fr/5/?do=rss",

	/* real link http://akrilon.free.fr/shaarly/?do=rss */
	"http://akrilon.free.fr/shaarly/5?do=rss",

	/* HS */
	"http://neros.fr/links/?do=rss",

	/* HS */
	"http://www.theologique.ch/shaarli/?do=rss",

	/* HS */
	"http://alva-films.aryo.eu/?do=rss",

	/* HS */
	"http://nexen.mkdir.fr/shaarli/?do=rss",

	/* HS */ 
	"http://link.shortbrain.org/?do=rss",
	
	/* real link http://perso.ens-lyon.fr/guillaume.aupy/shaarli/?do=rss */
	"https://gaupy.org/shaarli/?do=rss",

	/* real link http://www.famille-boucher.org/links/?do=rss */
	"https://www.famille-boucher.org/links/?do=rss",

	/* HS */ 
	"https://ex0artefact.eu/ahpuch/?do=rss",

	/* HS */
	"http://www.creposuke.lautre.net/?do=rss",

	/* real link https://www.shaarli.fr/shaarli/?do=rss */
	"https://shaarlo.fr/shaarli/?do=rss",

	/* HS */ 
	"https://gbovyn.be/shaarli/?do=rss",

	/* real link http://my.shaarli.fr/regishamann/?do=rss */
	"http://r129i.eu/links/?do=rss",

	/* HS */ 
	"https://tech-services.fr/shartech/?do=rss",
	
	/* HS */ 
	"http://www.cimourdain.lautre.net/shaarli/?do=rss",
	
	/* HS */ 
	"https://hamadr.fr/shaarli/?do=rss",

	/* HS. New : http://jcfrog.com/shaarli41/ */
	"http://jcfrog.com/shaarli/?do=rss",

	/* Duplicate with http://shaarli.warriordudimanche.net/ */
	"http://www.warriordudimanche.net/shaarli/?do=rss",

	/* real link  https://shaarli.dimtion.fr/?do=rss */
	"https://dimtion.taupincretin.com/shaarli/?do=rss",

	/* new link http://shaarli.kentaro.be/?do=rss */
	"http://katie.ktdev.info?do=rss",
	"http://katie.ktdev.info/?do=rss",

	/* new link  https://gilles.wittezaele.fr/liens/?do=rss */
	"http://gilles.wittezaele.fr/links/?do=rss",

	/* new link http://shaarli.sebw.info/?do=rss */
	"http://sebw.info?do=rss",

	/* new link https://yggz.org/Shaarli/?do=rss */
	"https://shaarli.yggz.org/?do=rss",

	/* real link http://shaarli.matronix.fr/?do=rss */
	"https://shaarli.matronix.fr/?do=rss",

	/* HS */
	"http://florian1.tk/shaarli/?do=rss",
	"http://martin-thepig.info.cm/sharlii/?do=rss",
	"http://etnadji.web4me.fr/links/?do=rss",
	"http://tech-services.fr/shartech/?do=rss",
	"http://hamadr.fr/shaarli/?do=rss",
	"http://gbovyn.be/shaarli/?do=rss",
	"http://ex0artefact.eu/ahpuch/?do=rss",
	"http://akrilon.free.fr/shaarly/?do=rss",
	"https://links.khrogos.info/?do=rss",
	"http://raphael.nicola.free.fr/Shaarli/?do=rss",
	"https://leomaradan.com/liens/?do=rss",
	"https://tiger-222.fr/shaarli/?do=rss",
	"http://neosting.net/links/?do=rss",
	"https://shaarli.amaury.carrade.eu/?do=rss",
	"http://hemltreppler.net/shaarli/?do=rss",
	"http://liens.sam7blog42.fr/?do=rss",
	"https://florian1.tk/shaarli/?do=rss",
	"http://shaarlo.fr/shaarli/?do=rss",
	"http://links.khrogos.info/?do=rss",
	"http://links.libox.fr/?do=rss",
	"http://tiger-222.fr/shaarli/?do=rss",
	"http://martin-thepig.info.cm/shaarli/?do=rss",
	"https://gilles.wittezaele.fr/links/?do=rss",
	"http://www.communaute-sla.org/shaarli/?do=rss",
	"https://shaarli.twyk.org/?do=rss",
	"https://ntimeu.fr/links/?do=rss",
	"https://shaarli.yggz.org/?do=rss",
	"http://www.slobberbone.net/shaarli/?do=rss",
	"http://biniouland.free.fr/Shaarli/?do=rss",
	"http://c3p0o.org/links?do=rss",
	"http://c3p0o.org/links/?do=rss",
	"http://www.davidsound.ovh/Shaarli?do=rss",
	"https://www.davidsound.ovh/Shaarli/?do=rss",
	"http://user23.net/links/?do=rss",
	"https://www.lemarsu.org/?do=rss",
	"http://aurelien.rocsaliere.org/découpages/?do=rss",
	"https://bookmarks.cdetc.fr/?do=rss",
	"http://www.famille-boucher.org/links/?do=rss",
	"https://geekz0ne.fr/shaarli-gaming/?do=rss",
	"https://trooper.fr/shaarli/?do=rss",
	"https://maxthon4.me/Shaarli/?do=rss",
	"https://links.pihair.fr/?do=rss",
	"https://pixelcafe.fr/links/?do=rss",
	"http://tools.mecton.info/shaarli/?do=rss",
	"https://oniricorpe.eu/links/?do=rss",
	"https://plakateck.no-ip.org/shaarli/?do=rss",
	"https://shaarli.aegirs.fr/?do=rss",
	"https://www.lincruste.com/shaarli/?do=rss",
	"https://lincruste.com/shaarli/?do=rss",
	"http://colibri-libre.org/liens/?do=rss",
	"https://shaarli.youm.org/?do=rss",
	"http://shaarli.nemocorp.info/?do=rss",
	"http://links.gilliek.ch/?do=rss",
	"https://erucipe.net/links/?do=rss",

	/* Demande de retrait par l'auteur */
	"https://lehollandaisvolant.net/rss.php?mode=links",
	"https://lehollandaisvolant.net/rss.php?do=rss&amp;mode=links",
	"https://lehollandaisvolant.net/rss.php?do=rss&mode=links",

	/* HS */
	"http://geekz0ne.fr/shaarli-gaming/?do=rss",
	"http://marienfressinaud.fr/shaarli/?do=rss",
	"https://marienfressinaud.fr/shaarli/?do=rss",
	"http://www.skway.fr/links/?do=rss",
	"https://www.skway.fr/links/?do=rss",
	"https://mayaweb.fr:4443/links?do=rss",
	"http://pixelcafe.fr/links/?do=rss",
	"http://www.lincruste.com/shaarli/?do=rss",
	"http://maxthon4.me/Shaarli/?do=rss",
	"http://links.pihair.fr/?do=rss",
	"http://shaarli.aegirs.fr/?do=rss",
	"http://dukeart.free.fr/shaarli?do=rss",
	"http://dukeart.free.fr/shaarli/?do=rss",
	"http://shaarli.olivier-cosquer.fr/?do=rss",
	"http://www.davidsound.ovh/Shaarli/?do=rss",
	"http://poegraphie.net/bm/?do=rss",
	"http://www.ascadia.net/links/?do=rss",
	"http://pittux.ovh/shaarli/?do=rss",
	"http://hub.tomcanac.com/liens/?do=rss",
	"https://shaarli.tlevy.fr/?do=rss",
	"http://slavick.eu/shaarli/?do=rss",
	"https://shaarli.contestataire.net/?do=rss",
	"https://stgfop.com/p/news/?do=rss",
	"http://shaarli.h3b.us/?do=rss",
	"http://liens.tcit.fr/?do=rss",
	"http://shaarli.naeodeferra.fr/?do=rss",
	"http://bookmarks.ipefixe.fr/?do=rss",
	"https://goldy.furry.fr/shaarli/?do=rss",

	/* HS */
	"http://links.hostux.net/?do=rss",

	/* real link https://share-link.olympe.in/?do=rss */
	"https://share-link.olympe.in?do=rss",
	"http://share-link.olympe.in?do=rss",
	"http://share-link.olympe.in/?do=rss",

	/* real link https://id-libre.org/shaarli/?do=rss */
	"http://id-libre.org/shaarli/?do=rss",

	/* real link https://suumitsu.eu/links/?do=rss */
	"https://root.suumitsu.eu/links/?do=rss",

	/* real link https://links.green-effect.fr/?do=rss */
	"http://links.green-effect.fr/?do=flux_rss?do=rss ",
	"http://links.green-effect.fr?do=rss",

	/* HS */
	"https://nas.eownis.me/shaarli/?do=rss",
	"https://yggz.org/Shaarli/?do=rss",
	"https://eownis.myds.me/shaarli/?do=rss",
	"https://lzko.fr/shaarli/?do=rss",
	"https://links.gardouille.fr/?do=rss",
	"http://toutetrien.hostzi.com/links/?do=rss",
	"http://streisand.fr/shaarli?do=rss",
	"https://streisand.fr/shaarli/?do=rss",
	"http://stgfop.com/p/news/?do=rss",
	"http://genma.free.fr/shaarli/?do=rss",
	"https://www.korezian.net/liens/?do=rss",
	"https://viperr.org/shaarli/?do=rss",

	/* real link http://bookmarks.ecyseo.net/?do=rss */
	"http://bookmarks.ecyseo.com?do=rss",
	"http://bookmarks.ecyseo.net?do=rss",

	);
?>
