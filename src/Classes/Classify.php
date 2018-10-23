<?php

namespace BBCNewsClassifier\Classes;


use League\Pipeline\StageInterface;
use Phpml\Classification\NaiveBayes;
use Phpml\CrossValidation\StratifiedRandomSplit;
use Phpml\Dataset\ArrayDataset;
use Phpml\Dataset\FilesDataset;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\Tokenization\WordTokenizer;

class Classify implements StageInterface
{
    protected $classifier;
    protected $vectorizer;
    protected $tfIdTransformer;

    public function __construct()
    {
        $dataset = new FilesDataset('data/bbc_articles');

        $this->vectorizer = new TokenCountVectorizer(new WordTokenizer());
        $this->tfIdTransformer = new TfIdfTransformer();

        $samples = [];
        foreach ($dataset->getSamples() as $sample) {
            $samples[] = $sample[0];
        }

        $this->vectorizer->fit($samples);
        $this->vectorizer->transform($samples);

        $this->tfIdTransformer->fit($samples);
        $this->tfIdTransformer->transform($samples);

        $dataset = new ArrayDataset($samples, $dataset->getTargets());
        $randomSplit = new StratifiedRandomSplit($dataset, 0.1);
        $this->classifier = new NaiveBayes();
        $this->classifier->train($randomSplit->getTrainSamples(), $randomSplit->getTrainLabels());
    }

    public function __invoke($text)
    {
        $newSample = [$text];

        $this->vectorizer->transform($newSample);
        $this->tfIdTransformer->transform($newSample);

        $category = $this->classifier->predict($newSample)[0];

        return $category;
    }
}