def part1():
    with open("input.txt", "r") as f:
        file = f.read().splitlines()

    file.append("out:  ")

    graph_matrix: dict[str, set[str]] = dict()

    for line in file:
        name = line[:3]
        neighbours = line[5:].split(" ")
        graph_matrix[name] = neighbours

    print(count_paths("you", "out", graph_matrix))


def count_paths(start, end, graph_matrix):
    if start == end:
        return 1
    else:
        return sum((count_paths(node, end, graph_matrix) for node in graph_matrix[start]))


if __name__ == "__main__":
    part1()
