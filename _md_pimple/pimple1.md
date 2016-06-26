## strukturierte Applikationen mit Pimple II

## Talkers und Page / Unvollständig !!!!

	// file: /src/Talkers/TalkerInterface.php
	namespace GM\HelloWorld\Talkers;

	interface TalkerInterface
	{
	   public function talk();
	}

	// file: /src/Talkers/Paragraph.php
	namespace GM\HelloWorld\Talkers;

	class Paragraph implements TalkerInterface
	{
	   private $words;

	   public function __construct(array $words = array())
	   {
  		     $this->words = $words;
	   }

	   public function talk()
	   {
		     return '<p>'.implode(' ', $this->words).'</p>';
	   }
	 }

	 // file /src/Page.php
	 namespace GM\HelloWorld;
	 use GM\HelloWorld\Words\WordInterface;
	 use GM\HelloWorld\Talkers\Paragraph;

	 class Page
	 {
		   private $words;
		
		   public function addWord(WordInterface $word)
		   {
			     $this->words[] = $word->output();
				
			     return $this;
		   }

		   public function line()
		   {
			     $words = $this->words;
			     $this->words = array();
			     $p = new Paragraph($words);

			     return $p->talk();
			}
	 }