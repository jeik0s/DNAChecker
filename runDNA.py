from genetic_library import geneticAlgorithm, Element
from genetic_library.selection_models import equalitarianism

from random import randint, choice

HealthDNA = "cctcacagctatccgtgcggcagtagcggcgcaaatctattagcggcttaggtagaagttagcacggctcccgaatgtggaaattcgtcggtataccgca"
TARGET =    "cctcacagctatccgtgcggcagtagcggcgcaaatctattagataggaaggtagaagttagcacggctcccgaatgtggaaattcgtcggtataccgca"
Population = 500
trys = 150

class DNAsequence(Element):
    POSSIBILITIES = '''agtc'''

    def __init__(self, DNAsequence):
        self.DNAsequence = DNAsequence
        super().__init__()


    # Sprawdz przystosowanie - po prostu porównaj 2 stringi 
    def evaluate_function(self):
        diff = 0
        for letter1, letter2 in zip(self.DNAsequence, TARGET):
            if letter1 != letter2:
                diff += 1
        return diff

    # wez dwa dna przeklei troche z jednego i polacz od lososwego indexu do losowego indexu
    def crossover_DNA(self, element2: 'Element' ) -> 'Element':
        length = int(randint(0, len(self.DNAsequence) - 1))
        new_DNAsequence = self.DNAsequence[:length] + element2.DNAsequence[length:]
        return DNAsequence(new_DNAsequence)

    # Mutacja - zamien litere
    def mutation_of_DNA(self):
        random_index = randint(0, len(self.DNAsequence) - 1)
        DNAsequence_as_list = list(self.DNAsequence)
        DNAsequence_as_list[random_index] = choice(self.POSSIBILITIES)
        self.DNAsequence = "".join(DNAsequence_as_list)

    # wypisanie elementu "printable"
    def __repr__(self):
        return self.DNAsequence


def first_generation_creator():
    return [DNAsequence(HealthDNA) for _ in range(Population)]


def stop_condition(string, current_fitness, i):
    return current_fitness == 0

whole_process = '''{
    "HealthyDNA":"''' + str(HealthDNA) + '''",
    "UnhealthyDNA": "''' + str(TARGET) + '''",
    "ElementsInPopulation": "''' + str(Population) + '''",
    "NumberOfPopulation": "''' + str(trys) + '''",
    "Data":{
    '''
next_try = 0;

for i in range(trys):
    json_file = '"'+str(next_try)+'":' + '{'
    ga = geneticAlgorithm(first_generation_creator, equalitarianism, stop_condition)
    for result in ga.run():
        json_file = json_file + result + ","
    json_file = json_file[:-1]
    json_file = json_file + "}"
    # json_filesentence.strip()
    # print(json_file)
    whole_process = whole_process + json_file + ",";
    next_try = next_try + 1;
whole_process = whole_process[:-1]
whole_process = whole_process + "}}"

file = open("output.json","w+")
file.write(whole_process)
file.close;