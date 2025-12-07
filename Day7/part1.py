def part1():
    with open("Day7/input.txt", "r") as f:
        input = f.read().splitlines()

    beams = set()
    beams.add(input[0].find("S"))

    score = 0
    for row in range(2,len(input)):
        to_remove = set()
        to_add = set()
        for pos in beams:
            if input[row][pos] == "^":
                score+=1
                to_remove.add(pos)
                to_add.add(max(0,pos-1))
                to_add.add(min(len(input[0])-1, pos+1))

        for pos in to_remove:
            beams.remove(pos)

        for pos in to_add:
            beams.add(pos)

    print(score)



if __name__ == "__main__":
    part1()
